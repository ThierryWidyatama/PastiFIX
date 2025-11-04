<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PastiFIX - Solusi Renovasi Rumah Anda</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

</head>
<body data-bs-spy="scroll" data-bs-target="#main-nav">

    <nav id="main-nav" class="navbar navbar-expand-lg fixed-top navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/img/logo.png') }}" alt="PastiFIX Logo" style="height: 70px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#service">Service</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#why-us">Why Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimoni">Testimoni</a>
                    </li>

                    @auth
                        <li class="nav-item ms-lg-3 dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Halo, {{ \Illuminate\Support\Str::words(Auth::user()->name, 2, '') }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="d-flex align-items-center px-3 py-2">
                                        
                                        <img src="{{ Auth::user()->profile_picture_url ? Storage::url(Auth::user()->profile_picture_url) : asset('assets/img/default-avatar.png') }}"
                                             alt="User Avatar" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        
                                        <div class="text-start">
                                            <div style="font-weight: 700; color: #333; line-height: 1.2;">{{ Auth::user()->name }}</div>
                                            <div style="font-size: 0.85rem; color: #777;">{{ Auth::user()->email }}</div>
                                        </div>
                                    </div>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('profil') }}">My Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('profil.activity') }}">My Activity</a></li>
                                <li><a class="dropdown-item" href="{{ route('profil.settings') }}">Account Setting</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Sign Out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-lg-3">
                            <a href="{{ route('login') }}" class="btn btn-brand fw-medium">Pesan</a>
                        </li>
                    @endguest
                    </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="PastiFIX Logo" class="mb-3" style="height: 50px;">
                    <h5 class="text-white">PT. PastiFIX Indonesia</h5>
                    <p class="text-white-50">Jl. Klipang No. 123, Semarang, Indonesia. Kami adalah solusi terpercaya untuk semua kebutuhan renovasi dan perbaikan bangunan Anda.</p>
                </div>
                <div class="col-lg-6 col-md-12 text-lg-end">
                    <h5 class="text-white mb-3">Bantuan & Sosial Media</h5>
                    <a href="#" class="btn btn-outline-brand me-2">Hubungi Kami</a>
                    <div class="social-icons mt-4">
                        <a href="#" class="text-white-50 me-3"><i class="bi bi-facebook fs-4"></i></a>
                        <a href="#" class="text-white-50 me-3"><i class="bi bi-twitter-x fs-4"></i></a>
                        <a href="#" class="text-white-50 me-3"><i class="bi bi-instagram fs-4"></i></a>
                        <a href="#" class="text-white-50"><i class="bi bi-linkedin fs-4"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-top pt-4 mt-4">
                <p class="text-center text-white-50 mb-0">Copyright © 2025 PastiFIX</p>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
    // Navbar scroll effect
    const nav = document.querySelector('#main-nav');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });

    // Swiper Initializer (REVISED)
    const swiper = new Swiper('.testimonial-slider', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 3, // <-- Kunci utama di sini
        loop: true,
        coverflowEffect: {
            rotate: 0,
            stretch: 80, // Jarak antar slide
            depth: 200, // Efek 3D
            modifier: 1,
            slideShadows: false, // Bayangan bisa dihilangkan agar lebih bersih
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>
</body>
</html>