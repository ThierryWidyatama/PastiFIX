<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Ganti ke halaman yang kamu mau
            return route('home'); // misal kamu mau arahkan ke halaman utama
        }
    }
}
