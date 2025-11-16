{{-- PENTING: GANTI 'layouts.default' dengan layout master Metronic-mu --}}
@extends('admin.template.layout') 

@section('title', 'Tambah Kategori Baru')

@section('content')

<!--begin::Card-->
<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header mt-6">
        <div class="card-title">
            <h2>Tambah Kategori Layanan Baru</h2>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!-- Tampilkan error validasi (jika ada) -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops! Ada yang salah:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!--[FIX] Tambah 'enctype' untuk upload file-->
        <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
            @csrf <!-- Token Keamanan Laravel -->

            <!--begin::Input group - Nama Kategori-->
            <div class="mb-10 fv-row">
                <label for="name" class="required form-label">Nama Kategori</label>
                <input type="text" class="form-control form-control-solid" id="name" name="name" 
                       placeholder="Contoh: Perbaikan Atap Bocor" value="{{ old('name') }}" required>
                <div class="text-muted fs-7">Nama kategori layanan yang akan dilihat oleh user.</div>
            </div>
            <!--end::Input group-->

            <!--[BARU] Input Harga-->
            <div class="mb-10 fv-row">
                <label for="price" class="form-label">Harga Mulai Dari</label>
                <input type="number" class="form-control form-control-solid" id="price" name="price" 
                       placeholder="Contoh: 150000" value="{{ old('price') }}">
                <div class="text-muted fs-7">Masukkan angka saja, tanpa "Rp" atau titik. Contoh: 150000</div>
            </div>
            <!--end::Input group-->

            <!--begin::Input group - Deskripsi-->
            <div class.mb-10 fv-row">
                <label for="description" class="form-label">Deskripsi (Opsional)</label>
                <textarea class="form-control form-control-solid" id="description" name="description" 
                          rows="3" placeholder="Jelaskan sedikit tentang layanan ini">{{ old('description') }}</textarea>
            </div>
            <!--end::Input group-->

            <!--[BARU] Input Gambar-->
            <div class="mb-10 fv-row">
                <label for="image" class="form-label">Gambar Kategori</label>
                <input type="file" class="form-control form-control-solid" id="image" name="image" accept="image/*">
                <div class="text-muted fs-7">Upload gambar (JPG, PNG, GIF) maks 2MB.</div>
            </div>
            <!--end::Input group-->
            
            <!--begin::Actions-->
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="{{ route('kategori.index') }}" class="btn btn-light me-3">
                    Batal
                </a>
                <!--end::Button-->
                
                <!--begin::Button-->
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">
                        Simpan Kategori
                    </span>
                </button>
                <!--end::Button-->
            </div>
            <!--end::Actions-->

        </form>
        <!--end::Form-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

@endsection