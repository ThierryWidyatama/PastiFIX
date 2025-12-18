<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\MsRole;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    protected $title;
    protected $subtitle;

    public function __construct(Request $request)
    {
        $this->title = 'Pengaturan Website';
        $action = $request->route()->getActionMethod();

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
        // function insert_log($activity,$ref_id = null,$json = null)
        if (!isAccess('list', get_module_id('option'), auth()->user()->role_id)) {
            insert_log('Mencoba akses ' . $this->subtitle . ' namun tidak punya akses ' . $this->subtitle, null);
            abort(404);
        }

        insert_log('Mengakses halaman ' . $this->subtitle);

        view()->share([
            'title' => $this->title,
            'subtitle' => $this->subtitle,
        ]);
    }
    /**
     * Tampilkan daftar semua pesanan (Index).
     */
    public function index(Request $request)
    {
        // Mulai Query
        $query = Order::with(['user', 'category', 'mandor']);

        // 1. [LOGIC FILTER STATUS UPDATED]
        if ($request->filled('status')) {
            
            // [FIX] Jika statusnya 'ALL_CANCELLED', cari semua jenis batal
            if ($request->status == 'ALL_CANCELLED') {
                $query->whereIn('status', ['CANCELLED', 'REJECTED_BY_ADMIN', 'REJECTED_BY_MANDOR']);
            } 
            // [FIX] Jika statusnya 'ALL_PROCESS', cari semua yg sedang jalan (Opsional, biar konsisten dgn grafik)
            elseif ($request->status == 'ALL_PROCESS') {
                $query->whereIn('status', ['APPROVED_IN_PROGRESS', 'PENDING_MANDOR_QUOTE', 'COMPLETED_PENDING_PAYMENT']);
            }
            // Jika status spesifik biasa
            else {
                $query->where('status', $request->status);
            }
        }

        // 2. LOGIC SEARCH (Tetap sama)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail pesanan & form update status/mandor.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'category', 'projectAddress', 'mandor'])->findOrFail($id);

        // === [LOGIC BARU: AUTO-FIX HARGA DASAR] ===
        // Cek apakah di tabel rincian biaya sudah ada "Biaya Dasar"
        $hasBasePrice = $order->costItems()->where('item_name', 'like', 'Biaya Dasar%')->exists();

        // Jika BELUM ADA, dan Kategorinya punya harga, kita suntikkan otomatis
        if (!$hasBasePrice && $order->category->price > 0) {
            $order->costItems()->create([
                'id' => \Illuminate\Support\Str::uuid(),
                'item_name' => "Biaya Dasar: " . $order->category->name,
                'price' => $order->category->price
            ]);

            // Hitung ulang total biar sinkron
            $totalCost = $order->costItems()->sum('price');
            $order->update(['estimated_cost' => $totalCost]);

            // Refresh data order biar item barunya muncul di view
            $order->refresh();
        }
        // ===========================================

        // Cari Role ID untuk 'Mandor' (MDR)
        $mandorRole = MsRole::where('code', 'MDR')->first();
        
        // Ambil semua user yang punya role Mandor
        $mandors = [];
        if ($mandorRole) {
            $mandors = User::where('role_id', $mandorRole->id)->get();
        }

        return view('admin.orders.show', compact('order', 'mandors'));
    }

    /**
     * Proses update status dan mandor.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|string',
            'mandor_id' => 'nullable|uuid|exists:users,id',
        ]);

        $order->update([
            'status' => $request->status,
            'mandor_id' => $request->mandor_id,
        ]);

        return redirect()->route('admin.orders.show', $id)->with('success', 'Pesanan berhasil diperbarui!');
    }

    /**
     * [BARU] Simpan item timeline baru.
     */
    public function storeTimeline(Request $request, $order_id)
    {
        $request->validate([
            'work_date' => 'required|date',
            'description' => 'required|string|max:255',
        ]);

        $order = Order::findOrFail($order_id);

        $order->workTimelines()->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'work_date' => $request->work_date,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Timeline berhasil ditambahkan!');
    }

    /**
     * [BARU] Simpan/Update item biaya (dan update total harga).
     */
    public function storeCost(Request $request, $order_id)
    {
        // 1. [FIX] Hapus titik dari input harga (Format Rupiah JS -> Angka Murni)
        if ($request->has('price')) {
            $cleanPrice = str_replace('.', '', $request->price);
            $request->merge(['price' => $cleanPrice]);
        }

        // 2. Validasi
        $request->validate([
            'item_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $order = Order::findOrFail($order_id);

        // 3. Tambah item biaya baru
        $order->costItems()->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'item_name' => $request->item_name,
            'price' => $request->price, // Ini sekarang sudah angka murni (cth: 80000)
        ]);

        // 4. Hitung ulang total harga di tabel orders
        $totalCost = $order->costItems()->sum('price');
        $order->update(['estimated_cost' => $totalCost]);

        return redirect()->back()->with('success', 'Item biaya berhasil ditambahkan & Total update!');
    }

    /**
     * [BARU] Hapus item biaya (jika salah input).
     */
    public function destroyCost($id)
    {
        $item = \App\Models\CostItem::findOrFail($id);
        $order = $item->order;
        
        $item->delete();

        // Update total lagi
        $totalCost = $order->costItems()->sum('price');
        $order->update(['estimated_cost' => $totalCost]);

        return redirect()->back()->with('success', 'Item biaya dihapus!');
    }
    
    // [BARU] Hapus item timeline
    public function destroyTimeline($id)
    {
        $timeline = \App\Models\WorkTimeline::findOrFail($id);
        $timeline->delete();
        return redirect()->back()->with('success', 'Timeline dihapus!');
    }

    // Fungsi 1: Admin SETUJU batal
    public function approveCancel($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        // Ubah status jadi CANCELLED (Resmi Batal)
        $order->update(['status' => 'CANCELLED']);
        return back()->with('success', 'Pembatalan disetujui. Pesanan hangus.');
    }

    // Fungsi 2: Admin MENOLAK batal (Lanjut)
    public function rejectCancel($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        // Balikin status jadi PENDING (Lanjut cari mandor)
        $order->update(['status' => 'PENDING']);
        return back()->with('success', 'Pembatalan ditolak. Pesanan dilanjutkan.');
    }
}