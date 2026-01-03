<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../../" />
    <title>PastiFIX - Verifikiasi Email</title>
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
                    <h4 class="fw-bold">Masukkan Kode Verifikasi</h4>
                    <p class="text-muted small">Kami telah mengirim 6 digit kode ke email Anda. Cek inbox (atau spam).
                    </p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="form w-100" action="{{ route('verification.verify') }}" method="POST">
                    @csrf

                    <input type="hidden" name="user_id" value="{{ $user_id }}">

                    <div class="form-group-minimal">
                        <label for="verification_code">6 Digit Kode</label>
                        <input type="text" id="verification_code" name="verification_code"
                            class="form-control-minimal verification-code-input" required maxlength="6" autofocus />
                    </div>

                    <div class="d-grid mb-4 mt-5">
                        <button type="submit" class="btn btn-brand-auth">
                            Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const btn = form.querySelector('button[type="submit"]');

            if(form && btn) {
                form.addEventListener('submit', function() {
                    // Karena inputnya cuma satu, validitas biasanya aman
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Verifikasi...';
                });
            }
        });
    </script>
</body>
</html>
