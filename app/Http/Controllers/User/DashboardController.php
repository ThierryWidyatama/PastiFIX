<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http; // <-- PENTING

class DashboardController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        $address = Auth::user()->addresses()
                        ->where('is_saved', true) // <-- Filter ini juga
                        ->where('is_primary', true)
                        ->first();
        $baseOrdersQuery = $user->orders(); 
        $stats = [
            'on_progress' => $baseOrdersQuery->clone()->whereIn('status', ['PENDING_ADMIN_REVIEW', 'PENDING_MANDOR_QUOTE', 'PENDING_USER_APPROVAL', 'APPROVED_IN_PROGRESS'])->count(),
            'selesai' => $baseOrdersQuery->clone()->where('status', 'FINISHED')->count(),
            'cancelled' => $baseOrdersQuery->clone()->whereIn('status', ['REJECTED_BY_ADMIN', 'REJECTED_BY_MANDOR', 'CANCELLED'])->count(),
        ];
        return view('user.profile', [
            'user' => $user, 'address' => $address, 'stats' => $stats
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'address_line' => 'nullable|string',
            'rt_rw' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'landmark_details' => 'nullable|string',
            // [PENTING] Validasi koordinat
            'profile_latitude' => 'nullable', 
            'profile_longitude' => 'nullable',
        ]);

        // 1. Update Data User (Nama, HP, Foto)
        $userData = [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->profile_picture_url) {
                Storage::disk('public')->delete($user->profile_picture_url);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $userData['profile_picture_url'] = $path;
        } else if ($request->filled('cropped_avatar_data')) {
            // Logic Croppie Base64
            if ($user->profile_picture_url) {
                Storage::disk('public')->delete($user->profile_picture_url);
            }
            $imageData = $request->input('cropped_avatar_data');
            $imageData = preg_replace('/^data:image\/(png|jpeg);base64,/', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $decodedImage = base64_decode($imageData);
            $filename = 'avatars/' . Str::uuid() . '.jpeg';
            Storage::disk('public')->put($filename, $decodedImage);
            $userData['profile_picture_url'] = $filename;
        }

        $user->update($userData);

        // 2. [FIX UTAMA] Update Alamat Utama + KOORDINAT
        $user->addresses()->updateOrCreate(
            ['is_primary' => true],
            [
                'address_line' => $request->address_line,
                'rt_rw' => $request->rt_rw,
                'postal_code' => $request->postal_code,
                'landmark_details' => $request->landmark_details,
                
                // MAPPING DATA BARU
                'latitude' => $request->profile_latitude, 
                'longitude' => $request->profile_longitude,
            ]
        );

        return redirect()->route('profil')->with('success', 'Profil dan Lokasi berhasil diperbarui!');
    }

    /**
     * [BARU] Update password user.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ]);

        // 2. Cek apakah password lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama Anda tidak cocok.']);
        }

        // 3. Update password baru
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profil.settings')->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * [BARU] Update email user.
     */
    public function updateEmail(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi (pastikan email unik, KECUALI email user itu sendiri)
        $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        // 2. Update email
        $user->update([
            'email' => $request->email,
            // (Opsional) Jika ganti email, user harus verifikasi ulang
            // 'email_verified_at' => null, 
        ]);

        return redirect()->route('profil.settings')->with('success', 'Email berhasil diperbarui!');
    }

    /**
     * [BARU] Simpan alamat dari modal checkout.
     */
    public function storeAddressFromCheckout(Request $request)
    {
        $user = Auth::user();

        // Validasi
        $request->validate([
            'address_line' => 'required|string',
            'rt_rw' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'landmark_details' => 'nullable|string',
            // [PENTING] Pastikan lat/long boleh diterima
            'latitude' => 'nullable', 
            'longitude' => 'nullable',
        ]);

        // Logic Checkbox Simpan & Utama
        $isSaved = $request->has('is_saved'); 
        $isPrimary = $request->has('is_primary') && $isSaved;

        // Reset alamat utama lain jika yang baru ini dipilih jadi utama
        if ($isPrimary) {
            $user->addresses()->update(['is_primary' => false]);
        }

        // Jika ini alamat pertama, otomatis jadi utama & disimpan
        $isFirst = $user->addresses()->count() == 0;
        if($isFirst) {
            $isSaved = true;
            $isPrimary = true;
        }

        // dd($request->all());
        // Simpan ke Database
        $newAddress = $user->addresses()->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'address_line' => $request->address_line,
            'rt_rw' => $request->rt_rw,
            'postal_code' => $request->postal_code,
            'landmark_details' => $request->landmark_details,
            'is_primary' => $isPrimary,
            'is_saved' => $isSaved,
            
            // [FIX UTAMA] Jangan lupa simpan koordinatnya!
            'latitude' => $request->latitude, 
            'longitude' => $request->longitude,
        ]);

        // Redirect kembali ke halaman asal
        return redirect($request->input('redirect_to'))
                ->with('success', 'Alamat berhasil ditambahkan!')
                ->with('new_address_id', $newAddress->id); 
    }

    public function showActivity()
    {
        $user = Auth::user();

        // Ambil semua order user ini, urutkan dari yang terbaru
        // Kita load 'category' juga biar bisa nampilin nama layanannya
        $orders = $user->orders()
                       ->with('category')
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('user.activity', compact('orders'));
    }

    /**
     * [BARU] Tampilkan detail pesanan spesifik.
     */
    public function showActivityDetail($id)
    {
        $user = Auth::user();

        // Ambil order berdasarkan ID, pastikan milik user yg login
        // Load relasi: kategori, mandor, timeline, dan rincian biaya
        $order = \App\Models\Order::with(['category', 'mandor', 'workTimelines', 'costItems'])
                    ->where('user_id', $user->id)
                    ->findOrFail($id);

        return view('user.activity-detail', compact('order'));
    }

    /**
     * [BARU] Update alamat tertentu.
     */
    public function updateAddress(Request $request, $id)
    {
        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);
        
        $request->validate([
            'address_line' => 'required|string',
            'rt_rw' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'landmark_details' => 'nullable|string',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        // Logic Edit Utama (Sama seperti sebelumnya)
        if ($request->has('is_primary')) {
            $user->addresses()->update(['is_primary' => false]);
            $address->is_primary = true;
        } 

        $address->update($request->only([
            'address_line', 'rt_rw', 'postal_code', 'landmark_details', 'latitude', 'longitude'
        ]));
        
        $address->save(); 

        // [FIX BUG HILANG]
        // Jika alamat ini adalah "Sekali Pakai" (is_saved = 0),
        // Kita harus kirim lagi ID-nya ke session biar ServiceController mau nampilin lagi.
        if ($address->is_saved == 0) {
            return back()
                ->with('success', 'Alamat sementara berhasil diperbarui!')
                ->with('new_address_id', $address->id); // <--- INI KUNCINYA
        }

        return back()->with('success', 'Alamat berhasil diperbarui!');
    }

    /**
     * [BARU] Hapus alamat.
     */
    public function destroyAddress($id)
    {
        $address = \App\Models\UserAddress::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();
        return back()->with('success', 'Alamat dihapus!');
    }

    /**
     * [BARU] Set alamat jadi UTAMA.
     */
    public function setPrimaryAddress($id)
    {
        $user = Auth::user();
        // Set semua alamat user ini jadi false dulu
        $user->addresses()->update(['is_primary' => false]);
        
        // Set yang dipilih jadi true
        $address = $user->addresses()->findOrFail($id);
        $address->update(['is_primary' => true]);

        return back()->with('success', 'Alamat utama diubah!');
    }

    public function proxyReverseGeocode(Request $request)
    {
        // Laravel yang nembak ke Nominatim, bukan browser
        $response = Http::withHeaders([
            'User-Agent' => 'PastiFIX-App/1.0 (contact@pastifix.com)' // Ini "KTP" kita biar gak diblokir
        ])->get('https://nominatim.openstreetmap.org/reverse', [
            'format' => 'json',
            'lat' => $request->lat,
            'lon' => $request->lon,
            'accept-language' => 'id'
        ]);

        return $response->json();
    }

    /**
     * Proxy untuk Forward Geocoding (Alamat -> Koordinat)
     */
    public function proxySearchGeocode(Request $request)
    {
        $response = Http::withHeaders([
            'User-Agent' => 'PastiFIX-App/1.0 (contact@pastifix.com)'
        ])->get('https://nominatim.openstreetmap.org/search', [
            'format' => 'json',
            'q' => $request->q,
            'accept-language' => 'id'
        ]);

        return $response->json();
    }
}
