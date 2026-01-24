{{-- GANTI INI dengan layout master Metronic-mu --}}
@extends('admin.template.layout') 

@section('title', 'Edit Kategori: ' . $category->name)

@section('content')

<!--begin::Card-->
<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header mt-6">
        <div class="card-title">
            <h2>Edit Kategori: {{ $category->name }}</h2>
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

        <form action="{{ route('kategori.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- PILIHAN TIPE (Main vs Sub) -->
            <div class="mb-10">
                <label class="form-label fw-bold">Tipe Kategori</label>
                <div class="d-flex gap-5">
                    <!-- Opsi Kategori Utama -->
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type_main" value="main" 
                               {{ $category->parent_id == null ? 'checked' : '' }} 
                               onchange="toggleFormType()">
                        <label class="form-check-label" for="type_main">
                            Kategori Utama (Induk)
                        </label>
                    </div>

                    <!-- Opsi Sub Kategori -->
                    <div class="form-check">
                        <!-- Disable jika kategori ini punya anak (tidak boleh jadi anak orang lain) -->
                        <input class="form-check-input" type="radio" name="type" id="type_sub" value="sub" 
                               {{ $category->parent_id != null ? 'checked' : '' }} 
                               {{ $category->children()->count() > 0 ? 'disabled' : '' }} 
                               onchange="toggleFormType()">
                        <label class="form-check-label" for="type_sub">
                            Layanan Jasa (Sub Kategori)
                        </label>
                    </div>
                </div>
                
                <!-- Peringatan jika punya anak -->
                @if($category->children()->count() > 0)
                    <div class="form-text text-danger mt-2">
                        <i class="bi bi-exclamation-circle-fill text-danger me-1"></i>
                        Kategori ini adalah Induk yang memiliki {{ $category->children()->count() }} layanan di bawahnya. Anda tidak bisa mengubahnya menjadi Sub Kategori.
                    </div>
                @endif
            </div>

            <!-- DROPDOWN PARENT (Hanya muncul jika Sub Kategori) -->
            <div class="mb-10 fv-row" id="parent_input_group" style="display: none;">
                <label for="parent_id" class="required form-label">Pilih Kategori Induk</label>
                <select name="parent_id" id="parent_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Induk...">
                    <option value="">Pilih Induk...</option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" 
                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- NAMA KATEGORI -->
            <div class="mb-10 fv-row">
                <label for="name" class="required form-label">Nama Kategori</label>
                <input type="text" class="form-control form-control-solid" id="name" name="name" 
                       value="{{ old('name', $category->name) }}" required>
            </div>

            <!-- AREA KHUSUS LAYANAN (Harga & Gambar) -->
            <div id="service_input_group" style="display: none;">
                
                <!-- Input Harga -->
                <div class="mb-10 fv-row">
                    <label for="price" class="form-label">Harga Mulai Dari</label>
                    <input type="text" class="form-control form-control-solid rupiah-input" id="price" name="price" 
                           placeholder="Contoh: 150.000" 
                           value="{{ old('price', $category->price ? number_format($category->price, 0, ',', '.') : '') }}">
                    <div class="text-muted fs-7">Masukkan angka saja.</div>
                </div>

                <!-- Preview Gambar Lama -->
                <div class="mb-5 fv-row">
                    <label class="form-label">Gambar Saat Ini:</label>
                    <div class="mt-2">
                        <img src="{{ $category->image_url ? Storage::url($category->image_url) : 'https://placehold.co/150x100/EFEFEF/AAAAAA?text=N/A' }}" 
                             alt="Gambar Lama" class="img-thumbnail" style="max-width: 150px; max-height: 100px; object-fit: cover;">
                    </div>
                </div>

                <!-- Input Gambar Baru -->
                <div class="mb-10 fv-row">
                    <label for="image" class="form-label">Upload Gambar Baru (Opsional)</label>
                    <input type="file" class="form-control form-control-solid" id="image" name="image" accept="image/*">
                    <div class="text-muted fs-7">Jika Anda upload gambar baru, gambar lama akan diganti.</div>
                </div>
            </div>

            <!-- DESKRIPSI -->
            <div class="mb-10 fv-row">
                <label for="description" class="form-label">Deskripsi (Opsional)</label>
                <textarea class="form-control form-control-solid" id="description" name="description" 
                          rows="3">{{ old('description', $category->description) }}</textarea>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="d-flex justify-content-end">
                <a href="{{ route('kategori.index') }}" class="btn btn-light me-3">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Update Kategori</span>
                </button>
            </div>

        </form>
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

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
            
            // Reset value select2 jika pindah ke Main (Opsional, di edit lebih baik dibiarkan nilainya)
            // $('#parent_id').val(null).trigger('change'); 
        }
    }

    // Jalankan saat load agar form menyesuaikan data yang ada
    document.addEventListener('DOMContentLoaded', function() {
        toggleFormType();
    });
</script>
@endpush