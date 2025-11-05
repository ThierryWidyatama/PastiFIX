<!DOCTYPE html>
<html lang="en">
<head>
    <title>PastiFIX - Verifikasi Email</title>
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/auth-new.css') }}">
    <style>
        .verification-code-input {
            font-size: 2rem !important;
            letter-spacing: 10px;
            text-align: center;
        }
    </style>
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
                
                <div class="text-center mb-4">
                    <h4 class="fw-bold">Masukkan Kode Verifikasi</h4>
                    <p class="text-muted small">Kami telah mengirim 6 digit kode ke email Anda. Cek inbox (atau spam).</p>
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
                               class="form-control-minimal verification-code-input" 
                               required maxlength="6" autofocus />
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
    
    </body>
</html>