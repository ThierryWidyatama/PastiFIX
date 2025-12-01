<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    /**
     * [BARU] Tampilkan halaman semua review dengan filter.
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'mandor', 'order.category']); // Eager load biar ringan

        // Filter Bintang (1-5)
        if ($request->filled('star')) {
            $star = $request->star;
            // Kita filter berdasarkan rata-rata (mandor + service) / 2
            // Menggunakan RAW query agar bisa hitung rata-rata di SQL
            $query->whereRaw('FLOOR((rating_mandor + rating_service) / 2) = ?', [$star]);
        }

        // Default urutan: Terbaru
        $reviews = $query->orderBy('created_at', 'desc')->paginate(9)->withQueryString();

        // Hitung total review per bintang (untuk sidebar filter)
        // Ini agak advanced raw query, tapi efisien
        $counts = \DB::table('reviews')
            ->selectRaw('FLOOR((rating_mandor + rating_service) / 2) as star, count(*) as count')
            ->groupBy('star')
            ->pluck('count', 'star'); // Hasil: [5 => 10, 4 => 2, ...]

        return view('reviews.index', compact('reviews', 'counts'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating_mandor' => 'required|integer|min:1|max:5', // Validasi 1
            'rating_service' => 'required|integer|min:1|max:5', // Validasi 2
            'comment' => 'nullable|string|max:500',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        Review::create([
            'id' => Str::uuid(),
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'mandor_id' => $order->mandor_id,
            'rating_mandor' => $request->rating_mandor,   // Simpan Rating 1
            'rating_service' => $request->rating_service, // Simpan Rating 2
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}