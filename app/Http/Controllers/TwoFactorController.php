<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function showVerifyForm()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.2fa');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'twofa_code' => 'required',
            'g-recaptcha-response' => 'required'
        ], [
            'twofa_code.required' => 'Kode 2FA harus diisi',
            'g-recaptcha-response.required' => 'Silahkan centang captcha'
        ]);

        $user = User::where('twofa_code', $request->twofa_code)
                    ->where('twofa_expires_at', '>', now())
                    ->first();

        if ($user) {
            $user->twofa_code = null;
            $user->twofa_expires_at = null;
            $user->last_login_ip = $request->ip();
            $user->last_login_at = now();
            $user->save();

            Auth::login($user);

            insert_log('Username ' . $request->username . ' berhasil masuk sistem ');
            return response()->json(['status' => true, 'pesan' => 'Selamat datang, gunakan aplikasi dengan bijak :)']);
        }

        return back()->withErrors(['2fa_code' => 'The provided 2FA code is invalid or expired.']);
    }

    public function verifyLink(Request $request)
    {
        $user = User::where('twofa_code', $request->code)
                    ->where('twofa_expires_at', '>', now())
                    ->first();

        if ($user) {
            $user->twofa_code = null;
            $user->twofa_expires_at = null;
            $user->last_login_ip = $request->ip();
            $user->last_login_at = now();
            $user->save();

            Auth::login($user);

            return redirect()->intended('/home');
        }

        return redirect()->route('2fa.verify')->withErrors(['2fa_code' => 'The provided link is invalid or expired.']);
    }
}
