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

        if ($order->status != 'COMPLETED_PENDING_PAYMENT') {
            return redirect()->route('profil.activity.detail', $id)
                ->withErrors('Pesanan ini tidak dalam status menunggu pembayaran.');
        }

        // 2. Setup Config Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // 3. [FIX] Cek Token Lama
        // Kalau sudah punya token, pakai itu aja. Gak usah minta baru.
        if ($order->snap_token) {
            $snapToken = $order->snap_token;
        } else {
            // Kalau belum punya, baru minta ke Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $order->id, // Atau bisa tambahkan timestamp biar unik: $order->id . '-' . time()
                    'gross_amount' => (int) $order->estimated_cost,
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

            try {
                $snapToken = Snap::getSnapToken($params);
                
                // [FIX] Simpan Token ke Database
                $order->update(['snap_token' => $snapToken]);
                
            } catch (\Exception $e) {
                return back()->withErrors('Gagal terhubung ke payment gateway: ' . $e->getMessage());
            }
        }

        return view('services.payment', compact('order', 'snapToken'));
    }
}