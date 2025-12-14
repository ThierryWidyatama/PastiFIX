<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\LandingPage;
use App\Models\ProdukHukum;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Models\SliderLandingPage;
use App\Models\TipeDokumen;
use App\Models\Review; // <-- JANGAN LUPA INI

class LandingPageController extends Controller
{
    public function index()
    {
        $option = Option::first();

        if($option->is_landing_page == 0) {
            return redirect()->route('login');
        }
        
        // Data Landing Page Standar
        $data = LandingPage::first();
        $sliders = SliderLandingPage::orderBy('id', 'DESC')->where('status', 1)->get();
        $socmed = SocialMedia::where('status', 1)->get();
        $latest_docs = ProdukHukum::orderBy('id', 'DESC')->where('status', 1)->limit(5)->get();
        $most_viewed_docs = ProdukHukum::orderBy('view', 'DESC')->where('status', 1)->limit(5)->get();
        $tipe_dokumens = TipeDokumen::all();

        // Data Review (Untuk Carousel)
        $reviews = Review::with('user')
                         ->orderByRaw('(rating_mandor + rating_service) DESC') 
                         ->orderBy('created_at', 'desc') 
                         ->take(5) 
                         ->get();

        // === [BARU] LOGIKA STATISTIK DINAMIS ===
        
        // 1. Satisfaction (Hitung Rata-rata Bintang, konversi ke %)
        // Rumus: (Rata2 Bintang / 5) * 100
        $avgRating = Review::selectRaw('AVG((rating_mandor + rating_service) / 2) as aggregate')->value('aggregate');
        // Jika belum ada review, default 100% (biar bagus), jika ada hitung real
        $satisfactionRate = $avgRating ? round(($avgRating / 5) * 100) : 100;

        // 2. Active Users (Jumlah User Aktif)
        $userCountRaw = \App\Models\User::whereHas('role', function($q) {
            $q->where('code', 'USR');
        })->where('status', 1)->count();
        // Format angka (misal 1500 jadi 1.5K)
        $activeUsers = $userCountRaw >= 1000 ? round($userCountRaw / 1000, 1) . 'K' : $userCountRaw;

        // 3. Team Members (Jumlah Mandor)
        $teamCount = \App\Models\User::whereHas('role', function($q) {
            $q->where('code', 'MDR');
        })->where('status', 1)->count();


        return view('welcome', compact(
            'data', 'sliders', 'socmed', 'latest_docs', 
            'most_viewed_docs','tipe_dokumens', 'reviews',
            // Kirim variable baru
            'satisfactionRate', 'activeUsers', 'teamCount'
        ));
    }
}
