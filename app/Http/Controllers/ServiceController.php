<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Menampilkan halaman list semua layanan (kategori).
     */
    public function index(Request $request)
    {
        // 1. Ambil SEMUA kategori (untuk filter sidebar)
        $all_categories = Category::orderBy('name', 'asc')->get();

        // 2. Mulai query untuk layanan/jasa
        $query = Category::query(); // Kita query dari tabel Kategori

        // 3. Implementasi Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 4. Implementasi Filter (filters[] dari checkbox)
        if ($request->filled('filters')) {
            $query->whereIn('id', $request->filters);
        }

        // 5. Implementasi Sort
        switch ($request->sort) {
            case 'price_asc':
                // $query->orderBy('price', 'asc'); // Kita belum punya kolom 'price'
                $query->orderBy('name', 'asc');
                break;
            case 'price_desc':
                // $query->orderBy('price', 'desc');
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                // Default sort: Popular (bisa diganti 'name' dulu)
                $query->orderBy('name', 'asc');
        }

        // 6. Ambil data dengan Pagination (9 per halaman)
        $services = $query->paginate(9)->withQueryString(); // withQueryString() biar filter tetap nempel

        // 7. Lempar data ke view
        return view('services.main', [
            'services' => $services,
            'all_categories' => $all_categories
        ]);
    }

    /**
     * Menampilkan halaman detail layanan.
     * (Kita siapkan dulu, tapi belum kita buat view-nya)
     */
    public function detail($id)
    {
        // Cari kategori berdasarkan ID.
        // Kalau ga ketemu, otomatis halaman 404 Not Found.
        $service = \App\Models\Category::findOrFail($id);

        return view('services.detail', compact('service'));
    }

    public function showCheckout(Request $request)
    {
        // 1. Ambil ID layanan dari URL (yang kita kirim dari hal. detail)
        $serviceId = $request->query('service_id');
        $service = \App\Models\Category::find($serviceId);

        // Jika layanannya nggak ketemu, lempar balik
        if (!$service) {
            return redirect()->route('services.index')->withErrors('Layanan tidak ditemukan.');
        }

        // 2. Ambil data user & alamatnya
        $user = Auth::user();
        $addresses = $user->addresses()->orderBy('is_primary', 'desc')->get(); // Ambil semua alamat

        // 3. Hitung Rincian Biaya (Kita dummy dulu)
        $servicePrice = $service->price ?? 0;
        $adminFee = 15000; // Biaya layanan (contoh)
        $tax = 2500; // Pajak (contoh)
        $total = $servicePrice + $adminFee + $tax;

        $prices = [
            'service' => $servicePrice,
            'admin_fee' => $adminFee,
            'tax' => $tax,
            'total' => $total
        ];

        // 4. Lempar semua data ke view
        return view('services.checkout', [
            'service' => $service,
            'addresses' => $addresses,
            'prices' => $prices
        ]);
    }
}