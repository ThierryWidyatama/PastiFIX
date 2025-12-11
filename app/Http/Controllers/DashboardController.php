<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// [BARU] Import Model Kita
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    protected $title;
    protected $subtitle;

    public function __construct(Request $request)
    {
        $this->title = 'Dashboard';
        $action = $request->route()->getActionMethod();

        // Logika Judul Bawaan Template (JANGAN DIUBAH)
        switch ($action) {
            case 'create':
                $this->subtitle = $this->title . ' / Tambah';
                break;
            case 'show':
                $this->subtitle = $this->title . ' / Show';
                break;
            case 'edit':
                $this->subtitle = $this->title . ' / Edit';
                break;
            case 'list':
                $this->subtitle = $this->title . ' / List';
                break;
            default:
                $this->subtitle = $this->title . '';
                break;
        }

        // Cek Permission Bawaan Template (JANGAN DIUBAH)
        if (!isAccess('list', get_module_id('dashboard'), auth()->user()->role_id)) {
            insert_log('Mencoba akses ' . $this->subtitle . ' namun tidak punya akses ' . $this->subtitle, null);
            abort(404);
        }

        view()->share([
            'title' => $this->title,
            'subtitle' => $this->subtitle,
        ]);
    }

    /**
     * Tampilan Utama Dashboard (Kita Update Ini)
     */
    public function index()
    {
        // === 1. DATA UNTUK 4 KARTU DI ATAS ===
        
        // Kartu 1: Total Pendapatan (Seumur Hidup)
        $totalRevenue = Order::where('status', 'FINISHED')->sum('estimated_cost');

        // Kartu 2: Pendapatan Bulan Ini [BARU]
        $revenueThisMonth = Order::where('status', 'FINISHED')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('estimated_cost');

        // Kartu 3: Total Pesanan (Volume)
        $totalOrders = Order::count();

        // Kartu 4: Mandor Aktif
        $mandorCount = User::whereHas('role', function($q){ 
            $q->where('code', 'MDR'); 
        })->count();


        // === 2. DATA UNTUK GRAFIK (LINE CHART) ===
        $monthlyRevenue = array_fill(1, 12, 0); 
        $revenueData = Order::selectRaw('MONTH(created_at) as month, SUM(estimated_cost) as total')
            ->where('status', 'FINISHED')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        foreach ($revenueData as $data) {
            $monthlyRevenue[$data->month] = $data->total;
        }

        // === 3. DATA UNTUK GRAFIK (DONUT CHART) ===
        $statusCounts = [
            'Selesai' => Order::where('status', 'FINISHED')->count(),
            'Proses'  => Order::whereIn('status', ['APPROVED_IN_PROGRESS', 'PENDING_MANDOR_QUOTE', 'COMPLETED_PENDING_PAYMENT'])->count(),
            'Pending' => Order::where('status', 'PENDING_ADMIN_REVIEW')->count(),
            'Batal'   => Order::whereIn('status', ['CANCELLED', 'REJECTED_BY_ADMIN', 'REJECTED_BY_MANDOR'])->count(),
        ];

        return view('admin.dashboard.index', compact(
            'totalRevenue', 'revenueThisMonth', 'totalOrders', 'mandorCount', // Data Kartu
            'monthlyRevenue', 'statusCounts' // Data Grafik
        ));
    }

    public function list()
    {
        return view('admin.dashboard.list');
    }
}