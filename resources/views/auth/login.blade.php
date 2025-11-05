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
<body id="kt_body" class="auth-page-new"> <div class="auth-container">
        
        <div class="auth-container-left">
            <a href="/" class="auth-logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="PastiFIX Logo">
                <span>PastiFIX</span>
            </a>
        </div>

        <div class="auth-container-right">
            <div class="auth-card">
                
                <div class="auth-tabs">
                    <a href="{{ route('register') }}">Sign Up</a>
                    <a href="{{ route('login') }}" class="active">Sign In</a>
                </div>

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                <form class="form w-100" novalidate="novalidate" id="login_form"
                      action="{{ route('login.auth') }}" method="POST">
                    @csrf

                    <div class="form-group-minimal">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" autocomplete="off"
                               class="form-control-minimal" required />
                    </div>

                    <div class="form-group-minimal">
                        <label for="password">Password</label>
                        <input class="form-control-minimal" type="password" id="password"
                               name="password" autocomplete="off" required />
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="remember_me" value="1" />
                            <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">Remember me</span>
                        </label>
                        <a href="#" class="link-forgot">Forgot Password?</a>
                    </div>
                    <br>
                    <div class="g-recaptcha mb-4" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"
                         data-action="LOGIN"></div>
                    <br>
                    <div class="d-grid mb-4">
                        <button type="submit" id="login_submit" class="btn btn-brand-auth">
                            <span class="indicator-label">Sign In</span>
                        </button>
                    </div>
                    <br>
                    <div class="text-center text-muted fw-semibold fs-6">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="link-register">Sign up</a>
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
            $('#login_submit').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Logging in',
                    text: 'Silahkan tunggu...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                Swal.showLoading();
                var formData = $('#login_form').serialize();

                $.ajax({
                    url: '{{ route('login.auth') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        Swal.close();
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.pesan,
                            }).then(() => {
                                // [FIX 3] Arahkan ke URL dinamis dari Controller
                                document.location = response.redirect_url; 
                            });
                        } else if (response.status == '2fa_required' && response['2fa_required']) {
                            window.location.href = response.redirect_url;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Login!',
                                text: response.pesan
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let errors = xhr.responseJSON.errors;
                        let firstErrorMessage = '';
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                firstErrorMessage = errors[key][0]; 
                                break; 
                            }
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal login!',
                            text: firstErrorMessage,
                            showConfirmButton: true,
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>