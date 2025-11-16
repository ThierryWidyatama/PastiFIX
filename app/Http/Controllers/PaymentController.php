<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function show($id)
    {
        // 1. Cari Order
        $order = Order::with('user')->where('user_id', Auth::id())->findOrFail($id);

        // 2. Validasi Status
        if ($order->status != 'COMPLETED_PENDING_PAYMENT') {
            return redirect()->route('profil.activity.detail', $id)
                ->withErrors('Pesanan ini tidak dalam status menunggu pembayaran.');
        }

        // 3. Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // 4. Buat Parameter Transaksi
        // 'order_id' harus unik. Kita pakai UUID order kita.
        $params = [
            'transaction_details' => [
                'order_id' => $order->id, 
                'gross_amount' => (int) $order->estimated_cost, // Harus integer
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone_number,
            ],
            'item_details' => [
                [
                    'id' => 'TOTAL-PAYMENT',
                    'price' => (int) $order->estimated_cost,
                    'quantity' => 1,
                    'name' => 'Total Tagihan Renovasi'
                ]
            ]
        ];

        // 5. Minta Snap Token dari Midtrans
        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return back()->withErrors('Gagal terhubung ke payment gateway: ' . $e->getMessage());
        }

        // 6. Tampilkan View dengan Token
        return view('services.payment', compact('order', 'snapToken'));
    }
}