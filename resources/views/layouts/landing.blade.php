<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PastiFIX - Solusi Renovasi Rumah Anda</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

</head>

<body data-bs-spy="scroll" data-bs-target="#main-nav">

    <nav id="main-nav" class="navbar navbar-expand-lg fixed-top navbar-dark">
        <div class="container position-relative"> <!-- [PENTING] position-relative untuk acuan tengah -->

            <!-- 1. KIRI: LOGO -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="PastiFIX Logo" class="logo-navbar">
            </a>

            <!-- 2. TENGAH: USER PROFILE (KHUSUS MOBILE) -->
            @auth
                <div class="d-lg-none position-absolute start-50 top-50 translate-middle">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-white" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- Foto Kecil -->
                            <img src="{{ Auth::user()->profile_picture_url ? Storage::url(Auth::user()->profile_picture_url) : asset('assets/img/default-avatar.png') }}"
                                alt="User" class="rounded-circle"
                                style="width: 30px; height: 30px; object-fit: cover; border: 1px solid #fff;">
                            <!-- Nama Depan Saja (Biar muat di HP) -->
                            <span class="fw-bold" style="font-size: 0.9rem;">{{ strtok(Auth::user()->name, ' ') }}</span>
                        </a>

                        <!-- Dropdown Menu Mobile (Centered) -->
                        <ul class="dropdown-menu dropdown-menu-center mt-2 shadow-sm border-0"
                            style="left: 50%; transform: translateX(-50%);">
                            <li>
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="text-start">
                                        <div style="font-weight: 700; color: #333; font-size: 0.9rem;">
                                            {{ Auth::user()->name }}</div>
                                        <div style="font-size: 0.75rem; color: #777;">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('profil') }}"><i class="bi bi-person me-2"></i>
                                    Profil Saya</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil.activity') }}"><i
                                        class="bi bi-list-check me-2"></i> Aktifitas Saya</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil.settings') }}"><i
                                        class="bi bi-gear me-2"></i> Pengaturan</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                </a>
                                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endauth

            <!-- 3. KANAN: HAMBURGER MENU -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- 4. MENU COLLAPSE (ISI BAWAH/KANAN) -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <!-- SAAT LOGIN: MENU MINIMAL -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('services.index') }}">Layanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}#testimoni">Testimonial</a>
                        </li>

                        <!-- USER MENU DESKTOP -->
                        <li class="nav-item ms-lg-3 dropdown d-none d-lg-block">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Halo, {{ \Illuminate\Support\Str::words(Auth::user()->name, 2, '') }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <div class="d-flex align-items-center px-3 py-2">
                                        <img src="{{ Auth::user()->profile_picture_url ? Storage::url(Auth::user()->profile_picture_url) : asset('assets/img/default-avatar.png') }}"
                                            class="rounded-circle me-3"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <div class="fw-bold">{{ Auth::user()->name }}</div>
                                            <div class="text-muted" style="font-size: 0.85rem;">{{ Auth::user()->email }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('profil') }}">Profil Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('profil.activity') }}">Aktifitas Saya</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('profil.settings') }}">Pengaturan</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Keluar
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- SAAT BELUM LOGIN: MENU LENGKAP -->
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about">Tentang Kami</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#service">Layanan</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#why-us">Mengapa Kami</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#testimoni">Testimonial</a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <a href="{{ route('login') }}" class="btn btn-brand fw-medium">Pesan</a>
                        </li>
                    @endauth
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
                    <img src="{{ asset('assets/img/logo.png') }}" alt="PastiFIX Logo" class="mb-3"
                        style="height: 120px;">
                    <h5 class="text-white">PT. PastiFIX Indonesia</h5>
                    <p class="text-white-50">Jl. Klipang No. 123, Semarang, Indonesia.<br> Kami adalah solusi
                        terpercaya untuk semua kebutuhan renovasi dan perbaikan bangunan Anda.</p>
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
        // Navbar scroll effect (Biarkan seperti semula)
        const nav = document.querySelector('#main-nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        var swiperClassic = new Swiper(".testimonial-slider-classic", {
            // Default (Mobile): 1 Kartu
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 4000, // Geser setiap 4 detik
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            // Responsif Breakpoints
            breakpoints: {
                // Tablet (>= 768px): 2 Kartu
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                // Desktop (>= 1024px): 3 Kartu (UKURAN PAS)
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });
        window.setLoading = function(btn) {
            if (!btn) return;
            if (!btn.hasAttribute('data-original-text')) {
                btn.setAttribute('data-original-text', btn.innerHTML);
            }
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...';
        };

        window.resetLoading = function(btn) {
            if (!btn) return;
            btn.disabled = false;
            if (btn.hasAttribute('data-original-text')) {
                btn.innerHTML = btn.getAttribute('data-original-text');
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('submit', function(e) {
                const form = e.target;
                const btn = form.querySelector('button[type="submit"]');
                
                // Metronic kadang punya validasi sendiri, tapi ini layer keamanan tambahan
                if (btn && form.checkValidity()) {
                    window.setLoading(btn);
                    setTimeout(() => window.resetLoading(btn), 15000); 
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
