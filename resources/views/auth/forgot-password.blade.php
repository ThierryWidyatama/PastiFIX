<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lupa Password - PastiFIX</title>
    <!-- Load CSS yang sama dengan Login -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Outfit:300,400,500,600,700" />
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/auth-new.css') }}">
</head>

<body id="kt_body" class="auth-page-new"> 
    <div class="auth-container" style="min-height: auto; height: auto; max-width: 500px;">
        
        <!-- Kita pakai 1 kolom aja biar simpel -->
        <div class="auth-card w-100" style="box-shadow: none;">
            
            <div class="text-center mb-4">
                <a href="/" class="d-inline-block mb-3">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 50px;">
                </a>
                <h3 class="fw-bold">Lupa Password?</h3>
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
                    <input type="email" name="email" class="form-control-minimal" required value="{{ old('email') }}">
                </div>
                
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-brand-auth">Kirim Kode</button>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="link-forgot small">Kembali ke Login</a>
                </div>
            </form>

        </div>
    </div>
</body>
</html>