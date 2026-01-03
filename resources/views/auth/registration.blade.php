<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../../" />
    <title>PastiFIX - Registrasi</title>
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

                <div class="auth-tabs">
                    <a href="{{ route('register') }}" class="active">Registrasi</a>
                    <a href="{{ route('login') }}">Masuk</a>
                </div>

                <form class="form w-100" novalidate="novalidate" id="register_form"
                    action="{{ route('register.post') }}" method="POST">
                    @csrf

                    <div class="form-group-minimal">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" autocomplete="off"
                            class="form-control-minimal" required />
                    </div>

                    <div class="form-group-minimal">
                        <label for="username">Nama Pengguna</label>
                        <input type="text" id="username" name="username" autocomplete="off"
                            class="form-control-minimal" required />
                    </div>

                    <div class="form-group-minimal">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" autocomplete="off"
                            class="form-control-minimal" required />
                    </div>

                    <div class="form-group-minimal password-wrapper">
                        <label for="password">Kata Sandi</label>
                        <div class="password-field">
                            <input class="form-control-minimal" type="password" id="password" name="password"
                                autocomplete="off" required />
                            <button type="button" class="toggle-password" data-target="password"
                                aria-label="Toggle password visibility">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group-minimal password-wrapper">
                        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="password-field">
                            <input class="form-control-minimal" type="password" id="password_confirmation"
                                name="password_confirmation" autocomplete="off" required />
                            <button type="button" class="toggle-password" data-target="password_confirmation"
                                aria-label="Toggle password visibility">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" id="register_submit" class="btn btn-brand-auth">
                            <span class="indicator-label">Registrasi</span>
                        </button>
                    </div>
                    <br>
                    <div class="text-center text-muted fw-semibold fs-6">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="link-register">Masuk</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>

    @if ($errors->any())
        <script>
            // Pastikan dokumen siap
            document.addEventListener('DOMContentLoaded', function() {
                // Ambil error pertama
                var firstError = @json($errors->all())[0];

                Swal.fire({
                    icon: 'error',
                    title: 'Registrasi Gagal!',
                    text: firstError,
                    showConfirmButton: true,
                });
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const btn = document.getElementById('register_submit');

            if (form && btn) {
                form.addEventListener('submit', function() {
                    if (form.checkValidity()) {
                        btn.disabled = true;
                        btn.innerHTML =
                            '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (!input) return;

                    const isHidden = input.type === 'password';
                    input.type = isHidden ? 'text' : 'password';

                    icon.classList.toggle('bi-eye');
                    icon.classList.toggle('bi-eye-slash');
                });
            });
        });
    </script>

</body>

</html>
