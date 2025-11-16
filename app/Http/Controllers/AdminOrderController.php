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
    public function index()
    {
        // Ambil semua order, urutkan dari terbaru
        // Eager load 'user' dan 'category' biar query ringan
        $orders = Order::with(['user', 'category', 'mandor'])->orderBy('created_at', 'desc')->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail pesanan & form update status/mandor.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'category', 'projectAddress', 'mandor'])->findOrFail($id);

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
        $request->validate([
            'item_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $order = Order::findOrFail($order_id);

        // 1. Tambah item biaya baru
        $order->costItems()->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'item_name' => $request->item_name,
            'price' => $request->price,
        ]);

        // 2. Hitung ulang total harga di tabel orders
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
}