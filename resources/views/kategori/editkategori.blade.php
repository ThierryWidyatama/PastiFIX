{{-- GANTI INI dengan layout master Metronic-mu --}}
@extends('admin.template.layout') 

@section('title', 'Edit Kategori: ' . $category->name)

@section('content')

<!--begin::Card-->
<div class="card card-flush">
    <div class="card-header mt-6">
        <div class="card-title">
            <h2>Edit Kategori: {{ $category->name }}</h2>
        </div>
    </div>
    <div class="card-body pt-0">
        
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

        <!--[FIX] Action ke route 'update' dan method 'PUT' -->
        <form action="{{ route('kategori.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Method spoofing untuk UPDATE -->

            <!-- Nama Kategori -->
            <div class="mb-10 fv-row">
                <label for="name" class="required form-label">Nama Kategori</label>
                <!--[FIX] Tampilkan data lama (old) atau data dari DB -->
                <input type="text" class="form-control form-control-solid" id="name" name="name" 
                       placeholder="Contoh: Perbaikan Atap Bocor" 
                       value="{{ old('name', $category->name) }}" required>
            </div>
            
            <!--[MODIFIKASI] Input Harga-->
            <div class="mb-10 fv-row">
                <label for="price" class="form-label">Harga Mulai Dari</label>
                <!-- [UBAH] type="text" dan tambah class "rupiah-input" -->
                <input type="text" class="form-control form-control-solid rupiah-input" id="price" name="price" 
                       placeholder="Contoh: 150.000" value="{{ old('price') }}">
                <div class="text-muted fs-7">Masukkan angka saja.</div>
            </div>

            <!-- Deskripsi -->
            <div class.mb-10 fv-row">
                <label for="description" class="form-label">Deskripsi (Opsional)</label>
                <textarea class="form-control form-control-solid" id="description" name="description" 
                          rows="3">{{ old('description', $category->description) }}</textarea>
            </div>

            <!--[BARU] Preview Gambar Lama -->
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
            
            <!-- Actions -->
            <div class="d-flex justify-content-end">
                <a href="{{ route('kategori.index') }}" class="btn btn-light me-3">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Update Kategori</span>
                </button>
            </div>

        </form>
    </div>
</div>

@endsection