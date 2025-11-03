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
            'g-recaptcha-response' => 'required'
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi',
            'g-recaptcha-response.required' => 'Silahkan centang captcha'
        ]);

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return response()->json(['status' => false, 'pesan' => 'Akun Tidak Ditemukan']);
        }

        if ($user->status != 1) {
            // insert_log('Username ' . $request->username . ' mencoba masuk sistem, akun tidak aktif');
            return response()->json(['status' => false, 'pesan' => 'Akun Tidak Aktif']);
        }

        $remember = $request->has('remember_me') ? true : false;
        $credentials = ['username' => $request->username, 'password' => $request->password, 'status' => 1];

        if (Auth::attempt($credentials, $remember)) {
            // ... (Kode 2FA kamu ... biarkan saja)
            if ($user->is_twofa_enabled && $this->isUserLoggedInToday($user)) {
                // ... (logic 2FA) ...
                return response()->json([
                    'status' => '2fa_required',
                    'pesan' => '2FA is required. A code has been sent to your email.',
                    '2fa_required' => true,
                    'redirect_url' => route('2fa.verify')
                ]);
            }
            
            $user->last_login_ip = $request->ip();
            $user->last_login_at = now();
            $user->save();

            // insert_log('Username ' . $request->username . ' berhasil masuk sistem ');

            // [FIX 3] Logika Redirect Dinamis
            $redirect_url = '';
            // Asumsi relasi role() ada di model User
            if ($user->role && $user->role->code == 'USR') {
                $redirect_url = route('profil'); // Redirect ke /profil
            } else {
                $redirect_url = '/dashboard'; // Redirect ke admin dashboard
            }

            return response()->json([
                'status' => 'success', 
                'pesan' => 'Selamat datang, gunakan aplikasi dengan bijak :)',
                'redirect_url' => $redirect_url // <-- Kirim URL-nya
            ]);
        } else {
            // insert_log('Username ' . $request->username . ' mencoba masuk sistem, password salah');
            return response()->json(['status' => false, 'pesan' => 'Password Salah']);
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
        // 1. Tambahkan validasi untuk username
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' akan cek 'password_confirmation'
        ]);

        $data = $request->all();
        $user = $this->create($data); // Panggil fungsi 'create' kita yang sudah benar

        // Auth::login($user); // Matikan auto-login (sesuai request-mu)

        // Redirect ke halaman LOGIN dengan pesan sukses
        return redirect()->route('login')
                         ->with('success', 'Registrasi berhasil! Silakan login dengan username Anda.');
    }

    /**
     * Buat user baru. (INI MASIH RUSAK, AKAN KITA PERBAIKI NANTI)
     */
    public function create(array $data)
    {
        // 1. Ambil role "User" (USR) dari database
        $userRole = \App\Models\MsRole::where('code', 'USR')->first();
        if (!$userRole) {
            // Jika role USR tidak ada, ini adalah error fatal
            throw new \Exception("Role 'USR' not found. Please run seeder.");
        }

        // 2. Buat user baru
        return User::create([
            'id' => \Illuminate\Support\Str::uuid(), // Jangan lupa UUID
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'], // <-- WAJIB DIISI
            'password' => Hash::make($data['password']),
            'role_id' => $userRole->id, // <-- WAJIB DIISI (otomatis jadi 'USR')
            'status' => 1, // <-- WAJIB DIISI (otomatis aktif)
        ]);
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