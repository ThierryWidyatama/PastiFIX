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
            return redirect()->login();
        }
        
        $data = LandingPage::first();
        $sliders = SliderLandingPage::orderBy('id', 'DESC')->where('status', 1)->get();
        $socmed = SocialMedia::where('status', 1)->get();
        $latest_docs = ProdukHukum::orderBy('id', 'DESC')->where('status', 1)->limit(5)->get();
        $most_viewed_docs = ProdukHukum::orderBy('view', 'DESC')->where('status', 1)->limit(5)->get();
        $tipe_dokumens = TipeDokumen::all();

        $reviews = Review::with('user')
                         ->orderByRaw('(rating_mandor + rating_service) DESC') 
                         ->orderBy('created_at', 'desc') // Kalau nilai sama, ambil yg paling baru
                         ->take(6) 
                         ->get();

        // Jangan lupa kirim 'reviews' ke view
        return view('welcome', compact(
            'data', 'sliders', 'socmed', 'latest_docs', 
            'most_viewed_docs','tipe_dokumens', 'reviews' // <-- TAMBAHKAN INI
        ));
    }
}
