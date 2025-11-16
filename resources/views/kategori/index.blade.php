{{-- GANTI INI dengan layout master Metronic-mu --}}
@extends('admin.template.layout') 

@section('title', 'Manajemen Kategori')

@section('content')

<!--begin::Card-->
<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header mt-6">
        <div class="card-title">
            <h2>Manajemen Kategori Layanan</h2>
        </div>
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Button-->
            <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                <i class="ki-duotone ki-plus fs-2"></i>
                Tambah Kategori Baru
            </a>
            <!--end::Button-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!-- Tampilkan pesan sukses (jika ada) -->
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_categories_table">
            <!--begin::Table head-->
            <thead>
                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-50px">Gambar</th>
                    <th class="min-w-150px">Nama Kategori</th>
                    <th class="min-w-100px">Harga Mulai</th>
                    <th class="min-w-250px">Deskripsi</th>
                    <th class="text-end min-w-100px">Aksi</th>
                </tr>
            </thead>
            <!--end::Table head-->

            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">
                @forelse ($categories as $category)
                <tr>
                    <!--begin::Gambar-->
                    <td>
                        <div class="symbol symbol-50px">
                            <img src="{{ $category->image_url ? Storage::url($category->image_url) : 'https://placehold.co/50x50/EFEFEF/AAAAAA?text=N/A' }}" 
                                 alt="" class="object-fit-cover"/>
                        </div>
                    </td>
                    <!--end::Gambar-->

                    <!--begin::Nama-->
                    <td>
                        <span class="text-gray-800 fs-5 fw-bold">{{ $category->name }}</span>
                    </td>
                    <!--end::Nama-->

                    <!--begin::Harga-->
                    <td>
                        {{ $category->price ? 'Rp' . number_format($category->price, 0, ',', '.') : '-' }}
                    </td>
                    <!--end::Harga-->

                    <!--begin::Deskripsi-->
                    <td>
                        {{ \Illuminate\Support\Str::limit($category->description, 50, '...') }}
                    </td>
                    <!--end::Deskripsi-->

                    <!--begin::Aksi-->
                    <td class="text-end">
                        <a href="{{ route('kategori.edit', $category->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                            <i class="ki-duotone ki-pencil fs-2">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </a>
                        
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm btn-delete-kategori" 
                           data-name="{{ $category->name }}"
                           data-url="{{ route('kategori.destroy', $category->id) }}">
                            <i class="ki-duotone ki-trash fs-2">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>
                            </i>
                        </a>
                    </td>
                    <!--end::Aksi-->
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada kategori. Silakan <a href="{{ route('kategori.create') }}">tambah baru</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->

        <!--[FIX] Tampilkan link Pagination -->
        <div class="mt-5">
            {{ $categories->links() }}
        </div>

    </div>
    <!--end::Card body-->
    <form id="delete-kategori-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    // Pastikan dokumen sudah siap
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Tangkap semua tombol dengan class '.btn-delete-kategori'
        document.querySelectorAll('.btn-delete-kategori').forEach(function (button) {
            
            // 2. Tambahkan event listener 'click'
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Mencegah link default
                
                // 3. Ambil data dari tombol yang diklik
                const url = this.dataset.url;
                const name = this.dataset.name;
                const form = document.getElementById('delete-kategori-form');
                
                // 4. Set 'action' dari form tersembunyi
                form.action = url;
                
                // 5. Tampilkan SweetAlert konfirmasi
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Anda akan menghapus kategori '" + name + "'. Tindakan ini tidak bisa dibatalkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus Saja!'
                }).then((result) => {
                    // 6. Jika user klik "Ya, Hapus"
                    if (result.isConfirmed) {
                        // Submit form-nya
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush