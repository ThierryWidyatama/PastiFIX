<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- PENTING

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman My Profile.
     */
    public function showProfile()
    {
        // 1. Ambil data user yang lagi login
        $user = Auth::user();

        // 2. Ambil data alamatnya (yang udah kita bikin relasinya)
        // Kita ambil alamat 'primary'
        $address = $user->addresses()->where('is_primary', true)->first();

        // 3. Ambil data pesanannya (yang udah kita bikin relasinya)
        $orders = $user->orders(); // Ini masih query builder, belum diambil
        
        // 4. Hitung statistik pesanan
        $stats = [
            'on_progress' => $orders->whereIn('status', ['PENDING_ADMIN_REVIEW', 'PENDING_MANDOR_QUOTE', 'PENDING_USER_APPROVAL', 'APPROVED_IN_PROGRESS'])->count(),
            'selesai' => $orders->clone()->where('status', 'FINISHED')->count(),
            // [FIX 3] Ganti 'where' jadi 'whereIn'
            'cancelled' => $orders->clone()->whereIn('status', ['REJECTED_BY_ADMIN', 'REJECTED_BY_MANDOR', 'CANCELLED'])->count(),
        ];

        // 5. Lempar semua data ke view
        return view('user.profile', [
            'user' => $user,
            'address' => $address,
            'stats' => $stats
        ]);
    }
}