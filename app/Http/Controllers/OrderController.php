<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Category;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Proses Simpan Pesanan Baru
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'service_id' => 'required|exists:categories,id',
            'address_id' => 'required|exists:user_addresses,id',
        ], [
            'address_id.required' => 'Silakan pilih alamat survei terlebih dahulu.',
        ]);

        $user = Auth::user();
        $service = Category::find($request->service_id);

        // 2. Hitung Komponen Biaya
        $servicePrice = $service->price ?? 0;
        $adminFee = 15000;
        $tax = 2500;
        
        // Total awal
        $total = $servicePrice + $adminFee + $tax;

        // 3. Simpan Order Utama
        $order = Order::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'category_id' => $service->id,
            'project_address_id' => $request->address_id,
            'description' => 'Permintaan survei baru untuk ' . $service->name,
            'estimated_cost' => $total,
            'status' => 'PENDING_ADMIN_REVIEW',
        ]);

        // 4. [FIX] Simpan Rincian Biaya (Termasuk Harga Kategori!)
        $order->costItems()->createMany([
            [
                'item_name' => "Biaya Dasar: {$service->name}", // <-- INI TAMBAHANNYA
                'price' => $servicePrice
            ],
            [
                'item_name' => 'Biaya Layanan Platform',
                'price' => $adminFee
            ],
            [
                'item_name' => 'Pajak Estimasi',
                'price' => $tax
            ],
        ]);

        return redirect()->route('services.order');
    }
}