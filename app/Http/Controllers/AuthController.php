<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\SocialMedia;
use App\Models\MsRole; // <-- [FIX 3] TAMBAHKAN INI
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use App\Mail\SendVerificationCode;
use App\Mail\SendWelcomeEmail;
use App\Mail\SendResetPasswordCode;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function index()
    {
        if (Auth::check()) {
            // [FIX 3] Logika Redirect jika sudah login
            $user = Auth::user();
            // Asumsi relasi role() ada di model User
            if ($user->role && $user->role->code == 'USR') {
                return redirect()->route('profil');
            }
            return redirect()->route('dashboard.index'); // Ke admin dashboard
        }
        $option = Option::first();
        return view('auth.login', compact('option'));
    }

    /**
     * Tampilkan halaman registrasi.
     */
    public function registration(): View
    {
        $option = Option::first();
        return view('auth.registration', compact('option'));
    }

    /**
     * Proses login.
     */
    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        // [FIX 1] DECODE PASSWORD (Kebalikan dari Encode di JS)
        // Kita terima string acak, kita balikin jadi password asli
        $realPassword = base64_decode($request->password);

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return response()->json(['status' => false, 'pesan' => 'Akun Tidak Ditemukan']);
        }

        if ($user->status != 1) {
            return response()->json(['status' => false, 'pesan' => 'Akun Tidak Aktif']);
        }

        // [FIX 2] REMEMBER ME
        $remember = $request->boolean('remember_me');
        
        // Gunakan password asli yang sudah di-decode
        $credentials = [
            'username' => $request->username, 
            'password' => $realPassword, // <-- PENTING
            'status' => 1
        ];

        if (Auth::attempt($credentials, $remember)) {
            
            // --- Logika 2FA ---
            if ($user->is_twofa_enabled && $this->isUserLoggedInToday($user)) {
                $user->twofa_code = Str::random(6);
                $user->twofa_expires_at = now()->addMinutes(10);
                $user->save();
                $this->send2faCode($user);
                Auth::logout();
                return response()->json([
                    'status' => '2fa_required',
                    'pesan' => '2FA is required.',
                    'redirect_url' => route('2fa.verify')
                ]);
            }

            $user->last_login_ip = $request->ip();
            $user->last_login_at = now();
            $user->save();

            // Logika Redirect
            $redirect_url = '/dashboard'; 
            if ($user->role && $user->role->code == 'USR') {
                $redirect_url = route('profil');
            }

            return response()->json([
                'status' => 'success',
                'pesan' => "Selamat datang di PastiFIX, " . $user->name . "!",
                'redirect_url' => $redirect_url
            ]);
        } else {
            return response()->json(['status' => false, 'pesan' => 'Username atau Password Salah']);
        }
    }

    protected function isUserLoggedInToday($user)
    {
        $data = is_string($user->last_login_at) ? Carbon::parse($user->last_login_at)->isToday() : $user->last_login_at->isToday();
        return !$data;
    }

    protected function send2faCode($user)
    {
        // ... (fungsi 2FA kamu) ...
    }


    /**
     * Proses registrasi.
     */
    public function postRegistration(Request $request): RedirectResponse
    {
        // 1. Validasi (termasuk password kompleks)
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    // ->mixedCase() // Wajib huruf besar & kecil
                    ->numbers()   // Wajib angka
                    // ->symbols()   // Wajib simbol
            ],
        ]);

        $data = $request->all();
        $user = $this->create($data); // Panggil 'create'

        // 2. Kirim Email Verifikasi
        try {
            Mail::to($user->email)->send(new SendVerificationCode($user, $user->verification_code));
        } catch (\Exception $e) {
            // Handle jika email gagal kirim
            return back()->withInput()->withErrors(['email' => 'Gagal mengirim email verifikasi. Coba lagi.']);
        }

        // 3. Redirect ke halaman "Masukkan Kode"
        return redirect()->route('verification.notice', ['id' => $user->id])
                         ->with('success', 'Registrasi berhasil! Kami telah mengirim kode verifikasi ke email Anda.');
    }

    /**
     * Buat user baru. (INI MASIH RUSAK, AKAN KITA PERBAIKI NANTI)
     */
    public function create(array $data)
    {
        $userRole = \App\Models\MsRole::where('code', 'USR')->first();
        if (!$userRole) {
            throw new \Exception("Role 'USR' not found. Please run seeder.");
        }

        return User::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role_id' => $userRole->id,
            'status' => 0, // <-- 0 = TIDAK AKTIF
            'verification_code' => rand(100000, 999999), // 6 digit kode acak
            'verification_expires_at' => Carbon::now()->addMinutes(10), // Hangus dalam 10 menit
        ]);
    }

    public function showVerifyForm(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('login')->withErrors('User tidak ditemukan.');
        }

        // Kirim ID user ke view
        return view('auth.verify-email', ['user_id' => $user->id]);
    }

    /**
     * [BARU] Proses kode verifikasi yang dimasukkan.
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'user_id' => 'required|uuid|exists:users,id',
            'verification_code' => 'required|string',
        ]);

        $user = User::find($request->user_id);

        // 1. Cek jika kode salah
        if ($user->verification_code !== $request->verification_code) {
            return back()->withErrors('Kode verifikasi salah.');
        }

        // 2. Cek jika kode hangus
        if (Carbon::now()->isAfter($user->verification_expires_at)) {
            return back()->withErrors('Kode verifikasi telah hangus. Silakan daftar ulang.');
        }

        // 3. Sukses! Aktifkan user.
        $user->status = 1;
        $user->email_verified_at = Carbon::now();
        $user->verification_code = null; // Hapus kode
        $user->verification_expires_at = null; // Hapus expiry
        $user->save();

        // 4. Kirim Email Selamat Datang
        try {
            Mail::to($user->email)->send(new SendWelcomeEmail($user));
        } catch (\Exception $e) {
            // Abaikan jika gagal, user sudah terverifikasi
        }

        // 5. Redirect ke Login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Verifikasi berhasil! Akun Anda sudah aktif, silakan login.');
    }

    // 1. Tampilkan Form Lupa Password (Input Email)
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Proses Kirim Kode
    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Generate Kode
        $user->verification_code = rand(100000, 999999);
        $user->verification_expires_at = \Carbon\Carbon::now()->addMinutes(15);
        $user->save();

        // Kirim Email
        try {
            // [FIX] Pastikan parameter user & code dikirim dengan benar
            Mail::to($user->email)->send(new SendResetPasswordCode($user, $user->verification_code));
        } catch (\Exception $e) {
            return back()->withErrors('Gagal mengirim email: ' . $e->getMessage());
        }

        return redirect()->route('password.reset.form', ['id' => $user->id])
            ->with('success', 'Kode reset password telah dikirim ke email Anda.');
    }

    // 3. Tampilkan Form Reset (Input Kode & Password Baru)
    public function showResetPasswordForm($id)
    {
        // [FIX] Cari user dulu buat ambil emailnya
        $user = User::find($id);
        
        // Kalau user gak ketemu (misal ID ngawur), balikin ke login
        if (!$user) {
            return redirect()->route('login')->withErrors('User tidak ditemukan.');
        }

        // Kirim data user ke view
        return view('auth.reset-password', ['user' => $user]);
    }

    // 4. Proses Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'code' => 'required|numeric',
            'password' => 'required|min:6|confirmed', // Konfirmasi password
        ]);

        $user = User::find($request->user_id);

        // Cek Kode
        if ($user->verification_code != $request->code) {
            return back()->withErrors('Kode verifikasi salah.');
        }
        // Cek Expired
        if (\Carbon\Carbon::now()->isAfter($user->verification_expires_at)) {
            return back()->withErrors('Kode kadaluarsa.');
        }

        // Reset Password & Bersihkan Kode
        $user->password = Hash::make($request->password);
        $user->verification_code = null;
        $user->verification_expires_at = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login.');
    }

    /**
     * Proses logout.
     */
    public function logout(): RedirectResponse
    {
        // insert_log('Username ' . Auth::user()->username . ' keluar dari sistem');
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
