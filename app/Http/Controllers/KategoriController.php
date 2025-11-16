<?php

namespace App\Http\Controllers;

use App\Models\Category; // <-- [PENTING] Import model kita
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Kita butuh ini
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
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
     * Tampilkan daftar semua kategori.
     */
    public function index()
    {
        // Ambil semua kategori, urutkan, dan PAGINASI (10 data per halaman)
        $categories = Category::orderBy('created_at', 'desc')->paginate(10); // <-- INI FIX-NYA
        
        // Arahkan ke view 'index' (daftar) yang baru kita buat
        return view('kategori.index', compact('categories'));
    }

    /**
     * Tampilkan form untuk menambah kategori baru.
     */
    public function create()
    {
        return view('kategori.tambahkategori');
    }

    /**
     * Simpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $imageUrl = $path;
        }

        Category::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * [FIXED] Tampilkan form untuk mengedit kategori.
     */
    public function edit(Category $category)
    {
        // Laravel otomatis mencari Kategori berdasarkan ID ($category)
        return view('kategori.editkategori', compact('category'));
    }

    /**
     * [FIXED] Update kategori di database.
     */
    public function update(Request $request, Category $category)
    {
        // 1. Validasi
        $request->validate([
            // Validasi unik, tapi 'ignore' (abaikan) ID kategori ini sendiri
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id),
            ],
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Siapkan data update
        $data = $request->only(['name', 'description', 'price']);

        // 3. Logika Upload Gambar Baru (jika ada)
        if ($request->hasFile('image')) {
            // Hapus gambar lama (jika ada)
            if ($category->image_url) {
                Storage::disk('public')->delete($category->image_url);
            }

            // Simpan gambar baru
            $path = $request->file('image')->store('categories', 'public');
            $data['image_url'] = $path;
        }

        // 4. Update data ke database
        $category->update($data);

        // 5. Redirect ke halaman daftar (index)
        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus kategori dari database.
     */
    /**
     * [FIXED] Hapus kategori dari database.
     */
    public function destroy(Category $category)
    {
        // 1. Hapus gambar (jika ada)
        if ($category->image_url) {
            // Hapus file dari folder 'storage/app/public/categories'
            Storage::disk('public')->delete($category->image_url);
        }

        // 2. Hapus data kategori dari database
        $category->delete();

        // 3. Redirect kembali ke halaman daftar (index)
        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori "' . $category->name . '" berhasil dihapus!');
    }
}