@extends('admin.template.layout')

@section('content')
<div class="card card-flush">
    <div class="card-header mt-6">
        <div class="card-title">
            <h2>Registrasi Mandor Baru</h2>
        </div>
    </div>
    <div class="card-body pt-0">
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mandor.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mb-6">
                <div class="col-lg-6">
                    <label class="required form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control form-control-solid" placeholder="Nama Mandor" value="{{ old('name') }}" required />
                </div>
                <div class="col-lg-6">
                    <label class="required form-label">Username</label>
                    <input type="text" name="username" class="form-control form-control-solid" placeholder="Username Login" value="{{ old('username') }}" required />
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-6">
                    <label class="required form-label">Email</label>
                    <input type="email" name="email" class="form-control form-control-solid" placeholder="email@contoh.com" value="{{ old('email') }}" required />
                </div>
                <div class="col-lg-6">
                    <label class="required form-label">Nomor HP/WA</label>
                    <input type="text" name="phone_number" class="form-control form-control-solid" placeholder="08..." value="{{ old('phone_number') }}" required />
                </div>
            </div>

            <div class="mb-6">
                <label class="form-label">Foto Profil (Opsional)</label>
                <input type="file" name="avatar" class="form-control form-control-solid" accept="image/*" />
                <div class="text-muted fs-7">Format: png, jpg, jpeg. Maks: 2MB</div>
            </div>

            <div class="mb-10">
                <label class="required form-label">Password</label>
                <input type="password" name="password" class="form-control form-control-solid" placeholder="Password minimal 6 karakter" required />
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('mandor.index') }}" class="btn btn-light me-3">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Mandor</button>
            </div>
        </form>
    </div>
</div>
@endsection