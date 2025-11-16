<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment; // Kita akan isi tabel payments juga
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function receive(Request $request)
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // 2. Baca Notifikasi dari Midtrans
        try {
            $notification = new Notification();
        } catch (\Exception $e) {
            return response(['message' => 'Notification invalid'], 400);
        }

        // 3. Ambil data penting
        $transactionStatus = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraud = $notification->fraud_status;

        // 4. Cari Order di Database
        $order = Order::find($orderId);

        if (!$order) {
            return response(['message' => 'Order not found'], 404);
        }

        // 5. Logika Status Pembayaran
        if ($transactionStatus == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $order->status = 'COMPLETED_PENDING_PAYMENT'; // Masih challenge
                } else {
                    $order->status = 'FINISHED'; // Sukses
                }
            }
        } else if ($transactionStatus == 'settlement') {
            // INI YANG PALING PENTING (LUNAS)
            $order->status = 'FINISHED'; 
        } else if ($transactionStatus == 'pending') {
            $order->status = 'COMPLETED_PENDING_PAYMENT';
        } else if ($transactionStatus == 'deny') {
            $order->status = 'CANCELLED';
        } else if ($transactionStatus == 'expire') {
            $order->status = 'CANCELLED';
        } else if ($transactionStatus == 'cancel') {
            $order->status = 'CANCELLED';
        }

        // 6. Simpan perubahan status Order
        $order->save();

        // 7. (Opsional) Simpan log ke tabel 'payments' jika belum ada
        // Pastikan kamu sudah punya model Payment
        /*
        \App\Models\Payment::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'order_id' => $order->id,
            'amount' => $notification->gross_amount,
            'payment_gateway_ref' => $notification->transaction_id,
            'status' => ($order->status == 'FINISHED') ? 'success' : 'pending',
            'paid_at' => ($order->status == 'FINISHED') ? now() : null,
        ]);
        */

        return response(['message' => 'Notification processed']);
    }
}