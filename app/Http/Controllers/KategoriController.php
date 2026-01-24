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
        // Ambil Kategori Utama (yang parent_id NULL)
        // Eager load 'children' biar query efisien
        $categories = Category::whereNull('parent_id')
                              ->with('children')
                              ->orderBy('name', 'asc')
                              ->paginate(10); // Paginasi per Induk
        
        return view('kategori.index', compact('categories'));
    }

    /**
     * Tampilkan form untuk menambah kategori baru.
     */
    public function create()
    {
        // Ambil kategori yang TIDAK punya parent (berarti dia Kategori Utama)
        $parentCategories = Category::whereNull('parent_id')->orderBy('name', 'asc')->get();
        
        return view('kategori.tambahkategori', compact('parentCategories'));
    }

    /**
     * Simpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        // 1. [FIX KRUSIAL] Ubah String Kosong jadi NULL
        // Ini mencegah error UUID invalid saat parent_id dikirim sebagai ""
        if (empty($request->parent_id)) {
            $request->merge(['parent_id' => null]);
        }

        // [FIX] Bersihkan titik harga (Rupiah)
        if (empty($request->price)) {
            $request->merge(['price' => null]); // Jika kosong, set null
        } else {
            $cleanPrice = str_replace('.', '', $request->price);
            $request->merge(['price' => $cleanPrice]);
        }

        // 2. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id', // Sekarang aman karena nilainya NULL
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 3. Proses Gambar
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $imageUrl = $path;
        }

        // 4. Simpan ke Database
        Category::create([
            'id' => Str::uuid(),
            'parent_id' => $request->parent_id, // Ini sekarang NULL (aman) atau UUID (aman)
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
        // [FIX] Kita harus ambil daftar "Calon Bapak" (Kategori Utama)
        // Syarat: Ambil yang Induk (parent_id null) DAN bukan diri sendiri
        $parentCategories = Category::whereNull('parent_id')
                                    ->where('id', '!=', $category->id) 
                                    ->orderBy('name', 'asc')
                                    ->get();

        // Kirim $parentCategories ke view
        return view('kategori.editkategori', compact('category', 'parentCategories'));
    }

    /**
     * [FIXED] Update kategori di database.
     */
    public function update(Request $request, Category $category)
    {
        // 1. [FIX] Sanitasi Input (Sama seperti store)
        // Ubah string kosong jadi NULL
        if (empty($request->parent_id)) {
            $request->merge(['parent_id' => null]);
        }

        // Hapus titik Rupiah
        if ($request->has('price') && $request->price != null) {
            $cleanPrice = str_replace('.', '', $request->price);
            $request->merge(['price' => $cleanPrice]);
        } else {
            $request->merge(['price' => null]);
        }

        // 2. Validasi
        $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('categories')->ignore($category->id),
            ],
            // Pastikan parent_id valid (boleh null, boleh id kategori lain)
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 3. Siapkan data update
        // [PENTING] Jangan lupa masukkan 'parent_id' ke sini
        $data = $request->only(['name', 'description', 'price', 'parent_id']);

        // 4. Update Gambar jika ada
        if ($request->hasFile('image')) {
            if ($category->image_url) {
                Storage::disk('public')->delete($category->image_url);
            }
            $data['image_url'] = $request->file('image')->store('categories', 'public');
        }

        // 5. Eksekusi Update
        $category->update($data);

        return redirect()->route('kategori.index')->with('success', 'Kategori diperbarui!');
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