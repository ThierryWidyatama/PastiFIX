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

class DashboardController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        $address = $user->addresses()->where('is_primary', true)->first();
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
            'cropped_avatar_data' => 'nullable|string', // Validasi untuk data base64
            'address_line' => 'nullable|string',
            'rt_rw' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'landmark_details' => 'nullable|string',
        ]);

        $userData = [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ];

        if ($request->filled('cropped_avatar_data')) {
            if ($user->profile_picture_url) {
                Storage::disk('public')->delete($user->profile_picture_url);
            }
            $imageData = $request->input('cropped_avatar_data');
            $imageData = preg_replace('/^data:image\/(png|jpeg);base64,/', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $decodedImage = base64_decode($imageData);
            $filename = 'avatars/' . Str::uuid() . '.jpeg';
            
            // [FIX 403] TAMBAHKAN 'public' DI SINI
            Storage::disk('public')->put($filename, $decodedImage, 'public');
            
            $userData['profile_picture_url'] = $filename;
        }

        $user->update($userData);

        $user->addresses()->updateOrCreate(
            ['is_primary' => true],
            [
                'address_line' => $request->address_line,
                'rt_rw' => $request->rt_rw,
                'postal_code' => $request->postal_code,
                'landmark_details' => $request->landmark_details,
            ]
        );

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');
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
}