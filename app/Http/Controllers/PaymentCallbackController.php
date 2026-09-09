<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log; // [PENTING] Tambahkan Log

class PaymentCallbackController extends Controller
{
    public function receive(Request $request)
    {
        // 1. Setup Konfigurasi
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        try {
            // 2. Baca Notifikasi
            $notification = new Notification();
            
            // [DEBUG] Catat di Log kalau ada notifikasi masuk
            Log::info('Midtrans Webhook Masuk: ' . json_encode($notification));

            $transactionStatus = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderIdMidtrans = $notification->order_id;
            $fraud = $notification->fraud_status;

            // 3. Potong UUID (Hilangkan Timestamp -12345)
            // Format: UUID-TIMESTAMP (36 karakter UUID)
            $realOrderId = substr($orderIdMidtrans, 0, 36);

            // 4. Cari Order
            $order = Order::find($realOrderId);

            if (!$order) {
                Log::error('Midtrans Error: Order ID tidak ditemukan - ' . $realOrderId);
                return response(['message' => 'Order not found'], 404);
            }

            // 5. Update Status
            if ($transactionStatus == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['status' => 'COMPLETED_PENDING_PAYMENT']);
                    } else {
                        $order->update(['status' => 'FINISHED']);
                    }
                }
            } else if ($transactionStatus == 'settlement') {
                // [LUNAS] -> Ubah jadi FINISHED
                $order->update(['status' => 'FINISHED']);
                Log::info('Order ' . $order->id . ' Berhasil Diupdate ke FINISHED');
                
            } else if ($transactionStatus == 'pending') {
                $order->update(['status' => 'COMPLETED_PENDING_PAYMENT']);
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $order->update(['status' => 'CANCELLED']);
            }

            return response(['message' => 'OK']);

        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error: ' . $e->getMessage());
            return response(['message' => 'Error processing notification'], 500);
        }
    }
}