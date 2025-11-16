<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show($id)
    {
        // Pastikan order milik user yang login
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        // Pastikan statusnya memang belum bayar
        if ($order->status != 'COMPLETED_PENDING_PAYMENT') {
            return redirect()->route('profil.activity.detail', $id)
                ->withErrors('Pesanan ini tidak dalam status menunggu pembayaran.');
        }

        // NANTI: Di sini kita akan panggil Midtrans untuk dapat SNAP TOKEN
        // Untuk sekarang, kita return view sederhana atau dd() dulu

        return "Halaman Pembayaran Midtrans akan muncul di sini untuk Order #" . $order->id;
    }
}