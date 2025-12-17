@extends('layouts.dashboard')

@section('content')

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="card p-4">
    <div class="card-body">

        <h4 class="fw-bold">Pengaturan Akun</h4>
        <hr class="my-3">

        <form action="{{ route('profil.settings.email') }}" method="POST">
            @csrf

            <div class="mt-4">
                <h6 class="fw-bold">Email Kontak</h6>
                <p class="text-muted small">Email ini untuk pemberitahuan invoice pemesanan.</p>

                <div class="d-flex align-items-end justify-content-between mt-3">
                    <div class="flex-grow-1 me-4">
                        <label for="email" class="form-minimal-label">Email</label>
                        <input type="email" class="form-control form-minimal-input" id="email" name="email"
                               value="{{ Auth::user()->email }}" required>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-brand btn-sm">Simpan Email</button>
                    </div>
                </div>
            </div>
        </form>

        <hr class="my-5"> <form action="{{ route('profil.settings.password') }}" method="POST">
            @csrf

            <div class="mt-4">
                <h6 class="fw-bold">Kata Sandi</h6>
                <p class="text-muted small">Ganti kata kandi anda.</p>

                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <label for="current_password" class="form-minimal-label">Kata sandi saat ini</label>
                        <input type="password" class="form-control form-minimal-input"
                               id="current_password" name="current_password" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-minimal-label">Kata sandi baru</label>
                        <input type="password" class="form-control form-minimal-input"
                               id="password" name="password" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-minimal-label">Konfirmasi Kata sandi</label>
                        <input type="password" class="form-control form-minimal-input"
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
            </div>

            <div class="text-start mt-4">
                <button type="submit" class="btn btn-brand">Ganti Kata sandi</button>
            </div>
        </form>

    </div>
</div>

@endsection
