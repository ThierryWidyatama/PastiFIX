{{-- GANTI INI dengan layout master Metronic-mu --}}
@extends('admin.template.layout') 

@section('title', 'Manajemen Kategori')

@section('content')

<div class="card card-flush">
    <div class="card-header mt-6">
        <div class="card-title">
            <h2>Manajemen Kategori Layanan</h2>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                <i class="ki-duotone ki-plus fs-2"></i> Tambah Baru
            </a>
        </div>
    </div>

    <div class="card-body pt-0">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_categories_table">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-50px">Icon/Img</th>
                        <th class="min-w-250px">Nama Kategori / Layanan</th>
                        <th class="min-w-100px">Harga Mulai</th>
                        <th class="min-w-200px">Deskripsi</th>
                        <th class="text-end min-w-100px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @forelse ($categories as $parent)
                        
                        <!-- ========================== -->
                        <!-- BARIS 1: KATEGORI UTAMA (INDUK) -->
                        <!-- ========================== -->
                        <tr class="bg-light">
                            <!-- Gambar Induk (Initials) -->
                            <td>
                                <div class="symbol symbol-40px">
                                    <span class="symbol-label bg-white text-primary fs-3 fw-bold border border-secondary">
                                        {{ substr($parent->name, 0, 1) }}
                                    </span>
                                </div>
                            </td>
                            
                            <!-- Nama Induk (Tebal) -->
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-900 fs-5 fw-bolder">{{ $parent->name }}</span>
                                    <span class="badge badge-light-primary fw-bold fs-8 mt-1 w-auto me-auto">Kategori Utama</span>
                                </div>
                            </td>

                            <!-- Harga Induk (Strip) -->
                            <td><span class="text-muted fw-bold">-</span></td>

                            <!-- Deskripsi Induk -->
                            <td>
                                <span class="text-gray-600 fst-italic">{{ Str::limit($parent->description, 50) }}</span>
                            </td>

                            <!-- Aksi Induk -->
                            <td class="text-end">
                                <a href="{{ route('kategori.edit', $parent->id) }}" class="btn btn-icon btn-bg-white btn-active-color-primary btn-sm me-1 shadow-sm" title="Edit">
                                    <i class="bi bi-pencil-fill fs-5"></i>
                                </a>
                                <!-- Tombol Delete Induk (Peringatan Lebih Keras) -->
                                <a href="#" class="btn btn-icon btn-bg-white btn-active-color-danger btn-sm shadow-sm btn-delete-kategori" 
                                   data-name="{{ $parent->name }}"
                                   data-type="parent" 
                                   data-count="{{ $parent->children->count() }}"
                                   data-url="{{ route('kategori.destroy', $parent->id) }}"
                                   title="Hapus">
                                    <i class="bi bi-trash-fill fs-5"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- ========================== -->
                        <!-- LOOP: SUB KATEGORI (ANAK)  -->
                        <!-- ========================== -->
                        @foreach($parent->children as $child)
                            <tr>
                                <!-- Gambar Layanan -->
                                <td class="ps-5"> 
                                    <div class="symbol symbol-40px symbol-circle">
                                        <!-- Tampilkan gambar asli jika ada, atau placeholder -->
                                        <img src="{{ $child->image_url ? Storage::url($child->image_url) : 'https://placehold.co/50x50/FEC81A/333?text=' . substr($child->name, 0, 1) }}" 
                                             alt="" class="object-fit-cover"/>
                                    </div>
                                </td>

                                <!-- Nama Layanan (Menjorok dengan panah) -->
                                <td>
                                    <div class="d-flex align-items-center ms-4">
                                        <span class="text-gray-400 me-2 fs-3">↳</span>
                                        <span class="text-gray-700 fw-bold">{{ $child->name }}</span>
                                    </div>
                                </td>

                                <!-- Harga Layanan -->
                                <td>
                                    <span class="text-dark fw-bold">
                                        {{ $child->price ? 'Rp ' . number_format($child->price, 0, ',', '.') : 'Via Survei' }}
                                    </span>
                                </td>

                                <!-- Deskripsi Layanan -->
                                <td>
                                    <span class="text-muted fs-7">{{ Str::limit($child->description, 40) }}</span>
                                </td>

                                <!-- Aksi Layanan -->
                                <td class="text-end">
                                    <a href="{{ route('kategori.edit', $child->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn-delete-kategori" 
                                       data-name="{{ $child->name }}"
                                       data-type="child"
                                       data-url="{{ route('kategori.destroy', $child->id) }}">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-folder-x fs-3x text-muted mb-3"></i>
                                    <span class="text-muted fs-5">Belum ada kategori layanan. Silakan tambah baru.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $categories->links() }}
        </div>
    </div>
</div>

<!-- Form Hapus (Hidden) -->
<form id="delete-kategori-form" action="" method="POST" style="display: none;">
    @csrf @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hapus Kategori dengan SweetAlert
        document.querySelectorAll('.btn-delete-kategori').forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.dataset.url;
                const name = this.dataset.name;
                const type = this.dataset.type; // 'parent' atau 'child'
                const childCount = this.dataset.count; // Jumlah anak (jika parent)
                
                const form = document.getElementById('delete-kategori-form');
                form.action = url;
                
                // Logic Peringatan
                let title = 'Hapus Layanan?';
                let text = "Layanan '" + name + "' akan dihapus permanen.";
                let icon = 'warning';
                let confirmBtn = 'Ya, Hapus!';
                let confirmColor = '#d33';

                // Jika yg dihapus INDUK dan punya ANAK, kasih peringatan keras
                if (type === 'parent') {
                    title = 'Hapus Kategori Utama?';
                    if (childCount > 0) {
                        text = "PERINGATAN: Kategori '" + name + "' memiliki " + childCount + " layanan di dalamnya. Semuanya akan IKUT TERHAPUS!";
                        icon = 'error'; 
                    } else {
                        text = "Kategori Utama '" + name + "' akan dihapus.";
                    }
                }
                
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: confirmColor,
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: confirmBtn,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    });
</script>
@endpush