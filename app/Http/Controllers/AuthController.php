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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        $option = Option::first();
        return view('auth.login', compact('option'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration(): View
    {
        $option = Option::first();
        return view('auth.registration', compact('option'));
    }

    /**
     * Write code on Method
     *
     * @return response()
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
            insert_log('Username ' . $request->username . ' mencoba masuk sistem, akun tidak aktif');
            return response()->json(['status' => false, 'pesan' => 'Akun Tidak Aktif']);
        }

        $remember = $request->has('remember_me') ? true : false;
        $credentials = ['username' => $request->username, 'password' => $request->password, 'status' => 1];

        if (Auth::attempt($credentials, $remember)) {
            // check if the 2fa is enabled and user is not logged in today
            if ($user->is_twofa_enabled && $this->isUserLoggedInToday($user)) {
                // Generate 2fa code and set expires_at
                $user->twofa_code = Str::random(6);
                $user->twofa_expires_at = now()->addMinutes(10);
                $user->save();

                // Send 2fa code via email
                $this->send2faCode($user);

                // Logout the user and prompt the user to enter 2fa code
                Auth::logout();
                return response()->json([
                    'status' => '2fa_required',
                    'pesan' => '2FA is required. A code has been sent to your email.',
                    '2fa_required' => true,
                    'redirect_url' => route('2fa.verify')
                ]);
            }
            // if the 2fa is not enabled or the user is logged in today
            $user->last_login_ip = $request->ip();
            $user->last_login_at = now();
            $user->save();

            insert_log('Username ' . $request->username . ' berhasil masuk sistem ');

            return response()->json(['status' => 'success', 'pesan' => 'Selamat datang, gunakan aplikasi dengan bijak :)']);
        } else {
            insert_log('Username ' . $request->username . ' mencoba masuk sistem, password salah');
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
        $verificationUrl = route('2fa.verify.link', ['code' => $user->twofa_code]);
        $company_data = Option::first();
        $social_media = SocialMedia::where('status', 1)->get();

        Mail::send('emails.2fa', ['user' => $user, 'verificationUrl' => $verificationUrl, 'company_data' => $company_data, 'social_media' => $social_media], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your 2FA Verification Code');
        });
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $user = $this->create($data);

        Auth::login($user);

        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout(): RedirectResponse
    {
        insert_log('Username ' . Auth::user()->username . ' keluar dari sistem');
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
