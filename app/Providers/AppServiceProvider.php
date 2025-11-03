<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Option;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            // Coba konek ke database
            \DB::connection()->getPdo();

            // Kalau koneksi berhasil, baru cek tabel
            if (Schema::hasTable('ms_option')) {
                $option = \App\Models\Option::first();
                View::share('global_option', $option);
            }
        } catch (\Exception $e) {
            // Kalau belum ada database, lewati saja (biar migrate jalan lancar)
        }
    }

}
