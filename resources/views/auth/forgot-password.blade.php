<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../../" />
    <title>PastiFIX - Lupa Kata Sandi</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('assets/css/auth-new.css') }}">
</head>

<style>
    .verification-code-input {
        font-size: 2rem !important;
        letter-spacing: 10px;
        text-align: center;
    }
</style>

<body id="kt_body" class="auth-page-new">
    <div class="auth-container">

        <div class="auth-container-left">
            <!-- Logo -->
            <a href="/" class="auth-logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="PastiFIX Logo">
                <span>PastiFIX</span>
            </a>

            <!-- [BARU] Ilustrasi / Foto -->
            <!-- Saya pakai gambar placeholder renovasi rumah yang estetik -->
            <img src="https://i.ibb.co.com/1fYPFHzr/Adobe-Express-file.png" alt="Ilustrasi Renovasi"
                class="auth-illustration">

            <!-- Teks Pendukung (Opsional, biar gak sepi) -->
            <div class="text-center pe-5 d-none d-lg-block">
                <h5 class="fw-bold mb-1">Solusi Renovasi Terpercaya</h5>
                <p class="text-muted small">Cari tukang, pantau progres, beres!</p>
            </div>
        </div>

        <div class="auth-container-right">
            <div class="auth-card">

                <div class="text-center mb-4">
                    <h3 class="fw-bold" style="font-size: 20px;">Lupa Kata Sandi?</h3>
                    <p class="text-muted small">Masukkan email Anda untuk menerima kode reset.</p>
                </div>

                <!-- [FIX] TAMPILKAN PESAN ERROR/SUKSES DISINI -->
                @if (session('success'))
                    <div class="alert alert-success p-3 mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger p-3 mb-4" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- END FIX -->

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <div class="form-group-minimal">
                        <label>Email Terdaftar</label>
                        <input type="email" name="email" class="form-control-minimal" required
                            value="{{ old('email') }}">
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-brand-auth">Kirim Kode</button>
                    </div>

                    <div>
                        <a href="{{ route('login') }}" class="to-login small">Kembali ke Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
