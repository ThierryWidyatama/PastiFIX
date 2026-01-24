{{-- PENTING: GANTI 'layouts.default' dengan layout master Metronic-mu --}}
@extends('admin.template.layout') 

@section('title', 'Tambah Kategori Baru')

@section('content')
<div class="card card-flush">
    <div class="card-header mt-6">
        <div class="card-title">
            <h2>Tambah Data Baru</h2>
        </div>
    </div>
    <div class="card-body pt-0">
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- PILIHAN JENIS INPUT (Radio Button) -->
            <div class="mb-10">
                <label class="form-label fw-bold">Apa yang ingin Anda tambahkan?</label>
                <div class="d-flex gap-5">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type_main" value="main" checked onchange="toggleFormType()">
                        <label class="form-check-label" for="type_main">
                            Kategori Utama (Induk) <br> <span class="text-muted small">Cth: Pekerjaan Atap, Pekerjaan Lantai</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type_sub" value="sub" onchange="toggleFormType()">
                        <label class="form-check-label" for="type_sub">
                            Layanan Jasa (Sub Kategori) <br> <span class="text-muted small">Cth: Pasang Genteng, Cat Tembok</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- DROPDOWN PARENT (Hanya muncul jika Sub Kategori) -->
            <div class="mb-10 fv-row" id="parent_input_group" style="display: none;">
                <label for="parent_id" class="required form-label">Pilih Kategori Induk</label>
                <select name="parent_id" id="parent_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Induk...">
                    <option></option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- NAMA (Selalu Muncul) -->
            <div class="mb-10 fv-row">
                <label for="name" class="required form-label">Nama</label>
                <input type="text" class="form-control form-control-solid" id="name" name="name" placeholder="Masukkan nama..." required>
            </div>

            <!-- AREA KHUSUS LAYANAN (Harga & Gambar) -->
            <div id="service_input_group" style="display: none;">
                <div class="mb-10 fv-row">
                    <label for="price" class="form-label">Harga Mulai Dari</label>
                    <input type="text" class="form-control form-control-solid rupiah-input" id="price" name="price" placeholder="Contoh: 150.000">
                </div>

                <div class="mb-10 fv-row">
                    <label for="image" class="form-label">Gambar Layanan</label>
                    <input type="file" class="form-control form-control-solid" id="image" name="image" accept="image/*">
                </div>
            </div>

            <!-- DESKRIPSI (Selalu Muncul) -->
            <div class="mb-10 fv-row">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control form-control-solid" id="description" name="description" rows="3"></textarea>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('kategori.index') }}" class="btn btn-light me-3">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleFormType() {
        const isSub = document.getElementById('type_sub').checked;
        const parentGroup = document.getElementById('parent_input_group');
        const serviceGroup = document.getElementById('service_input_group');
        
        if (isSub) {
            // Mode Sub Kategori: Tampilkan Dropdown & Harga/Gambar
            parentGroup.style.display = 'block';
            serviceGroup.style.display = 'block';
        } else {
            // Mode Kategori Utama: Sembunyikan
            parentGroup.style.display = 'none';
            serviceGroup.style.display = 'none';
            
            // Reset value select2 jika pindah ke Main
            $('#parent_id').val(null).trigger('change');
        }
    }

    // Jalankan saat load (jaga-jaga old input)
    document.addEventListener('DOMContentLoaded', function() {
        toggleFormType();
    });
</script>
@endpush