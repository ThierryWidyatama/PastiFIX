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
            <a href="/" class="auth-logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="PastiFIX Logo">
                <span>PastiFIX</span>
            </a>
        </div>

        <div class="auth-container-right">
            <div class="auth-card">
                
                <div class="auth-tabs">
                    <a href="{{ route('register') }}" class="active">Sign Up</a>
                    <a href="{{ route('login') }}">Sign In</a>
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
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" autocomplete="off"
                               class="form-control-minimal" required />
                    </div>

                    <div class="form-group-minimal">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" autocomplete="off"
                               class="form-control-minimal" required />
                    </div>

                    <div class="form-group-minimal">
                        <label for="password">Password</label>
                        <input class="form-control-minimal" type="password" id="password"
                               name="password" autocomplete="off" required />
                    </div>

                    <div class="form-group-minimal">
                        <label for="password_confirmation">Confirm Password</label>
                        <input class="form-control-minimal" type="password" id="password_confirmation"
                               name="password_confirmation" autocomplete="off" required />
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" id="register_submit" class_name="btn btn-brand-auth">
                            <span class="indicator-label">Sign Up</span>
                        </button>
                    </div>
                    <br>
                    <div class="text-center text-muted fw-semibold fs-6">
                        Already have an account?
                        <a href="{{ route('login') }}" class="link-register">Sign In</a>
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
    
</body>
</html>