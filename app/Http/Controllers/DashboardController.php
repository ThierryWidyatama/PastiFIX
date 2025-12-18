<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// [BARU] Import Model Kita
use App\Models\Order;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RevenueExport;
use App\Models\ImportedRevenue;
use App\Imports\RevenueImport;

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
    public function index(Request $request)
    {
        $filterYear = $request->input('year', date('Y'));
        $filterMonth = $request->input('month', date('m'));

        // === KARTU ATAS ===
        $totalRevenue = Order::where('status', 'FINISHED')->sum('estimated_cost');
        $revenueSelectedMonth = Order::where('status', 'FINISHED')
            ->whereMonth('created_at', $filterMonth)
            ->whereYear('created_at', $filterYear)
            ->sum('estimated_cost');
        $totalOrders = Order::count();
        $actionNeeded = Order::whereIn('status', ['PENDING_ADMIN_REVIEW', 'CANCEL_REQUESTED'])->count();
        $mandorCount = User::whereHas('role', function($q){ $q->where('code', 'MDR'); })->count();

        // === PERSIAPAN DATA HARIAN ===
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $filterMonth, $filterYear);
        
        // 1. Data System (Dari Order)
        $dailyRevenueSystem = array_fill(1, $daysInMonth, 0);
        $systemData = Order::selectRaw('DAY(created_at) as day, SUM(estimated_cost) as total')
            ->where('status', 'FINISHED')
            ->whereMonth('created_at', $filterMonth)
            ->whereYear('created_at', $filterYear)
            ->groupBy('day')
            ->get();
        foreach ($systemData as $data) {
            $dailyRevenueSystem[$data->day] = $data->total;
        }

        // 2. Data Import (Dari Excel Manual)
        $dailyRevenueImport = array_fill(1, $daysInMonth, 0);
        // Pastikan Model ImportedRevenue sudah dibuat & diimport di atas
        // Jika belum ada modelnya, codingan ini akan error. 
        // Kalau tabel imported_revenues belum ada, hapus blok ini dulu.
        if (class_exists('App\Models\ImportedRevenue')) {
            $importData = \App\Models\ImportedRevenue::selectRaw('DAY(revenue_date) as day, SUM(amount) as total')
                ->whereMonth('revenue_date', $filterMonth)
                ->whereYear('revenue_date', $filterYear)
                ->groupBy('day')
                ->get();
            foreach ($importData as $data) {
                $dailyRevenueImport[$data->day] = $data->total;
            }
        }

        // === DONUT CHART ===
        $statusCounts = [
            'Selesai' => Order::where('status', 'FINISHED')->whereMonth('created_at', $filterMonth)->whereYear('created_at', $filterYear)->count(),
            'Proses'  => Order::whereIn('status', ['APPROVED_IN_PROGRESS', 'PENDING_MANDOR_QUOTE', 'COMPLETED_PENDING_PAYMENT'])->whereMonth('created_at', $filterMonth)->whereYear('created_at', $filterYear)->count(),
            'Pending' => Order::where('status', 'PENDING_ADMIN_REVIEW')->whereMonth('created_at', $filterMonth)->whereYear('created_at', $filterYear)->count(),
            'Batal'   => Order::whereIn('status', ['CANCELLED', 'REJECTED_BY_ADMIN', 'REJECTED_BY_MANDOR'])->whereMonth('created_at', $filterMonth)->whereYear('created_at', $filterYear)->count(),
        ];

        $recentOrders = Order::with(['user', 'category'])->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard.index', compact(
            'totalRevenue', 'revenueSelectedMonth', 'totalOrders', 'actionNeeded', 'mandorCount', 'recentOrders',
            'statusCounts', 'filterYear', 'filterMonth',
            
            // [PENTING] Ini variabel yang bikin error kalau lupa dikirim
            'dailyRevenueSystem', 
            'dailyRevenueImport' 
        ));
    }

    public function list()
    {
        return view('admin.dashboard.list');
    }

    public function exportExcel(Request $request)
    {
        // Default: Bulan ini & Tahun ini jika tidak dipilih
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $fileName = 'Laporan_PastiFIX_' . $year . '-' . $month . '.xlsx';

        return Excel::download(new RevenueExport($month, $year), $fileName);
    }

    /**
     * [BARU] Download Template Excel Kosong
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_import_pendapatan.csv"',
        ];

        $columns = ['Tanggal', 'Jumlah', 'Keterangan'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            // [FIX] Ubah format contoh jadi dd/mm/yyyy
            // Contoh: 25/12/2025
            fputcsv($file, ['25/12/2025', '500000', 'Contoh Pemasukan (Format: dd/mm/yyyy)']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * [BARU] Proses Upload Excel
     */
    public function importRevenue(Request $request)
    {
        // [FIX] Validasi lebih santai.
        // Kita izinkan semua jenis file excel/csv/text
        $request->validate([
            'file' => 'required|file', 
        ]);

        try {
            // Proses Import
            Excel::import(new RevenueImport, $request->file('file'));
            
            return redirect()->back()->with('success', 'Data berhasil diimport! Cek grafik biru di bawah.');
            
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return back()->with('error', 'Gagal Import: Format data di dalam Excel salah.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function resetRevenue(Request $request)
    {
        // Ambil bulan & tahun dari input (atau default saat ini)
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Hapus data import yang cocok
        $deleted = \App\Models\ImportedRevenue::whereMonth('revenue_date', $month)
                    ->whereYear('revenue_date', $year)
                    ->delete();

        if ($deleted > 0) {
            return redirect()->back()->with('success', "Berhasil mereset $deleted data import untuk periode $month/$year.");
        }

        return redirect()->back()->with('warning', "Tidak ada data import yang ditemukan untuk periode $month/$year.");
    }
}