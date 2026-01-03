<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>PastiFIX - Reset Password</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" />
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS (Pakai CSS Auth yang sudah kita buat) -->
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/auth-new.css') }}">
</head>

<body id="kt_body" class="auth-page-new"> 

    <div class="auth-container">
        
        <!-- KIRI (ILUSTRASI & LOGO) -->
        <div class="auth-container-left">
            <a href="/" class="auth-logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="PastiFIX Logo">
                <span>PastiFIX</span>
            </a>

            <img src="https://img.freepik.com/free-vector/reset-password-concept-illustration_114360-7886.jpg?t=st=1732000000~exp=1732003600~hmac=abc12345" 
                 alt="Reset Password" 
                 class="auth-illustration">
                 
            <div class="text-center pe-5 d-none d-lg-block">
                <h5 class="fw-bold mb-1">Amankan Akun Anda</h5>
                <p class="text-muted small">Buat password baru yang kuat dan mudah diingat.</p>
            </div>
        </div>

        <!-- KANAN (FORM RESET) -->
        <div class="auth-container-right">
            <div class="auth-card">
                
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Reset Password</h2>
                    <p class="text-muted small mb-1">Untuk akun:</p>
                    <!-- [DINAMIS] Tampilkan Email User -->
                    <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill">
                        <i class="bi bi-envelope-fill me-1"></i> {{ $user->email }}
                    </span>
                </div>

                <!-- Alert Error -->
                @if ($errors->any())
                    <div class="alert alert-danger p-2 small mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- FORM -->
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    
                    <!-- Input Kode -->
                    <div class="form-group-minimal">
                        <label for="code">Kode Verifikasi (Cek Email)</label>
                        <input type="text" id="code" name="code" 
                               class="form-control-minimal text-center fw-bold fs-4 letter-spacing-2" 
                               placeholder="------" maxlength="6" required autofocus>
                    </div>

                    <!-- Input Password Baru -->
                    <div class="form-group-minimal mt-4">
                        <label for="password">Password Baru</label>
                        <div class="password-wrapper">
                            <input class="form-control-minimal" type="password" id="password" name="password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Konfirmasi Password -->
                    <div class="form-group-minimal mt-4">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <div class="password-wrapper">
                            <input class="form-control-minimal" type="password" id="password_confirmation" name="password_confirmation" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Tombol Submit -->
                    <div class="d-grid mb-4 mt-5">
                        <button type="submit" class="btn btn-brand-auth">
                            Ubah Password
                        </button>
                    </div>
                    
                    <!-- Link Kembali -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="link-forgot small">Batal, kembali ke Login</a>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const btn = form.querySelector('button[type="submit"]');

        if(form && btn) {
            form.addEventListener('submit', function() {
                if(form.checkValidity()) {
                    // Simpan teks asli (opsional)
                    const originalText = btn.innerHTML;
                    
                    // Matikan tombol & ubah jadi loading
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
                    
                    // Safety timeout (jaga-jaga error jaringan)
                    setTimeout(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }, 10000);
                }
            });
        }
    });
        // Script Show/Hide Password
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = "password";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }
        
        // Script Loading Button
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const btn = form.querySelector('button[type="submit"]');

            if(form && btn) {
                form.addEventListener('submit', function() {
                    if(form.checkValidity()) {
                        btn.disabled = true;
                        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
                    }
                });
            }
        });
    </script>
    
    <style>
        .letter-spacing-2 { letter-spacing: 5px; }
    </style>
    
</body>
</html>