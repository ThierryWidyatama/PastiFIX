<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MsRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MandorController extends Controller
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
     * Tampilkan daftar semua Mandor.
     */
    public function index()
    {
        // Ambil user yang punya role 'MDR' (Mandor)
        $mandors = User::whereHas('role', function($q) {
            $q->where('code', 'MDR');
        })->orderBy('created_at', 'desc')->get();

        return view('admin.mandor.index', compact('mandors'));
    }

    /**
     * Tampilkan form tambah Mandor.
     */
    public function create()
    {
        return view('admin.mandor.create');
    }

    /**
     * Simpan Mandor baru.
     */
    /**
     * Simpan Mandor baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        $mandorRole = MsRole::where('code', 'MDR')->first();
        if (!$mandorRole) {
            return back()->withErrors('Role Mandor (MDR) belum ada. Jalankan seeder!');
        }

        // [BARU] Logic simpan foto
        $profilePath = null;
        if ($request->hasFile('avatar')) {
            $profilePath = $request->file('avatar')->store('avatars', 'public');
        }

        User::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role_id' => $mandorRole->id,
            'status' => 1,
            'profile_picture_url' => $profilePath, // Simpan path foto
        ]);

        return redirect()->route('mandor.index')->with('success', 'Mandor baru berhasil ditambahkan!');
    }

    // Nanti bisa tambahkan edit/destroy di sini
}