<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../../" />
    <title>PastiFIX - Login</title>
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
                    <a href="{{ route('register') }}">Registrasi</a>
                    <a href="{{ route('login') }}" class="active">Masuk</a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form class="form w-100" novalidate="novalidate" id="login_form" action="{{ route('login.auth') }}"
                    method="POST">
                    @csrf

                    <div class="form-group-minimal">
                        <label for="username">Nama Pengguna</label>
                        <input type="text" id="username" name="username" autocomplete="off"
                            class="form-control-minimal" required />
                    </div>

                    <div class="form-group-minimal">
                        <label for="password">Kata Sandi</label>
                        
                        <!-- Wrapper sesuai CSS kamu -->
                        <div class="password-field">
                            <input class="form-control-minimal" type="password" id="password" name="password"
                                autocomplete="off" required />

                            <!-- Class disamakan jadi 'toggle-password' -->
                            <button type="button" class="toggle-password">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <label class="form-check form-check-inline">
                            <!-- [PASTIKAN INI] name="remember_me" dan value="1" -->
                            <input class="form-check-input" type="checkbox" name="remember_me" value="1" />
                            <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">Ingat Saya</span>
                        </label>

                        <!-- [FIX] Arahkan ke route password.request -->
                        <a href="{{ route('password.request') }}" class="link-forgot">Lupa Kata Sandi?</a>
                    </div>
                    <br>
                    {{-- <div class="g-recaptcha mb-4" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}" data-action="LOGIN">
                    </div> --}}
                    <br>
                    <div class="d-grid mb-4">
                        <button type="submit" id="login_submit" class="btn btn-brand-auth">
                            <span class="indicator-label">Masuk</span>
                        </button>
                    </div>
                    <br>
                    <div class="text-center text-muted fw-semibold fs-6">
                        Belum memiliki akun?
                        <a href="{{ route('register') }}" class="link-register">Registrasi</a>
                    </div>
                    <br>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-google"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>

    <script>
        $(document).ready(function() {
            // [FIX] TOMBOL LOGIN CLICK
            $('#login_submit').on('click', function(event) {
                event.preventDefault();

                // 1. Ambil Data Manual
                var username = $('input[name="username"]').val();
                var password = $('input[name="password"]').val();
                // Cek checkbox manual biar akurat
                var remember = $('input[name="remember_me"]').is(':checked') ? 1 : 0; 
                var token    = $('input[name="_token"]').val();

                // 2. [FIX 1] ENCODE PASSWORD KE BASE64
                // Ini biar karakter unik (!@#) gak dianggap virus sama hosting
                var encodedPassword = btoa(password);

                // 3. UI Loading (Cegah Spam Klik)
                var btn = $(this);
                var originalText = btn.html();
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Loading...');
                
                // Tampilkan Swal juga biar makin jelas
                Swal.fire({
                    title: 'Mencoba masuk',
                    text: 'Silahkan tunggu...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // 4. Kirim Data via AJAX
                $.ajax({
                    url: '{{ route('login.auth') }}',
                    type: 'POST',
                    data: {
                        username: username,
                        password: encodedPassword, // Kirim yang sudah di-encode
                        remember_me: remember,
                        _token: token
                    },
                    success: function(response) {
                        Swal.close(); // Tutup loading Swal
                        
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.pesan,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href = response.redirect_url;
                            });
                        } else if (response.status == '2fa_required') {
                            window.location.href = response.redirect_url;
                        } else {
                            // Gagal Login (Password Salah / Akun Mati)
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Masuk!',
                                text: response.pesan
                            });
                            // Balikin tombol biar bisa coba lagi
                            btn.prop('disabled', false).html(originalText);
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        // Balikin tombol
                        btn.prop('disabled', false).html(originalText);

                        let errorMsg = "Terjadi kesalahan sistem.";
                        
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // Error Validasi Laravel
                            let errors = xhr.responseJSON.errors;
                            for (let key in errors) {
                                errorMsg = errors[key][0];
                                break;
                            }
                        } else if (xhr.status === 403) {
                            errorMsg = "Akses Ditolak (403). Coba refresh atau hubungi admin.";
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Masuk!',
                            text: errorMsg,
                        });
                    }
                });
            });

            // Toggle Password Visibility
            // [FIX] Selector disesuaikan dengan CSS kamu: '.toggle-password'
            $(document).on('click', '.toggle-password', function() {
                // Cari input saudara-nya (sibling) di dalam div yang sama
                var input = $(this).siblings('input');
                var icon = $(this).find('i');
                
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('bi-eye-slash').addClass('bi-eye');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('bi-eye').addClass('bi-eye-slash');
                }
            });
        });
    </script>
</body>

</html>
