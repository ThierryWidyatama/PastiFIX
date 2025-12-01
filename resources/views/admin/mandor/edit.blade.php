@extends('admin.template.layout')

@section('content')
<div class="card card-flush">
    <div class="card-header mt-6">
        <div class="card-title"><h2>Edit Data Mandor</h2></div>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('mandor.update', $mandor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row mb-6">
                <div class="col-lg-6">
                    <label class="required form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control form-control-solid" value="{{ old('name', $mandor->name) }}" required />
                </div>
                <div class="col-lg-6">
                    <label class="required form-label">Username</label>
                    <input type="text" name="username" class="form-control form-control-solid" value="{{ old('username', $mandor->username) }}" required />
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-6">
                    <label class="required form-label">Email</label>
                    <input type="email" name="email" class="form-control form-control-solid" value="{{ old('email', $mandor->email) }}" required />
                </div>
                <div class="col-lg-6">
                    <label class="required form-label">Nomor HP/WA</label>
                    <input type="text" name="phone_number" class="form-control form-control-solid" value="{{ old('phone_number', $mandor->phone_number) }}" required />
                </div>
            </div>

            <div class="mb-6">
                <label class="form-label">Foto Profil (Upload jika ingin mengganti)</label>
                <input type="file" name="avatar" class="form-control form-control-solid" accept="image/*" />
            </div>

            <div class="mb-10">
                <label class="form-label">Password Baru (Kosongkan jika tidak diganti)</label>
                <input type="password" name="password" class="form-control form-control-solid" placeholder="********" />
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('mandor.index') }}" class="btn btn-light me-3">Batal</a>
                <button type="submit" class="btn btn-primary">Update Mandor</button>
            </div>
        </form>
    </div>
</div>
@endsection