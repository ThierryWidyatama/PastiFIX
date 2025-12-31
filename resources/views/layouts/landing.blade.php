<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PastiFIX - @yield('title')</title>
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
    <!-- MOBILE HEADER -->
    <header class="mobile-header d-lg-none">
        <div class="mobile-header-left">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
            <span>PastiFIX</span>
        </div>

        @auth
            <div class="mobile-header-right dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->profile_picture_url
                        ? Storage::url(Auth::user()->profile_picture_url)
                        : asset('assets/img/default-avatar.png') }}"
                        class="mobile-avatar">
                </a>

                <ul class="dropdown-menu dropdown-menu-end mobile-profile-dropdown shadow">
                    <li>
                        <a class="dropdown-item" href="{{ route('profil') }}">
                            <i class="bi bi-person me-2"></i> Profil Saya
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profil.activity') }}">
                            <i class="bi bi-clock-history me-2"></i> Aktivitas Akun
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profil.settings') }}">
                            <i class="bi bi-gear me-2"></i> Pengaturan
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                        </a>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-brand fw-medium">Pesan</a>
        @endauth
    </header>

    <nav id="main-nav" class="navbar navbar-expand-lg fixed-top navbar-dark">
        <div class="container position-relative"> <!-- [PENTING] position-relative untuk acuan tengah -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="PastiFIX Logo" style="height: 70px;">
            </a>

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
                            <a class="nav-link" href="{{ route('reviews.index') }}">Testimoni</a>
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
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- SAAT BELUM LOGIN: MENU LENGKAP -->
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about">Tentang Kami</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" hhref="{{ route('services.index') }}">Layanan</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#why-us">Mengapa Kami</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('reviews.index') }}">Testimoni</a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <a href="{{ route('login') }}" class="btn btn-brand fw-medium">Pesan</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="content-wrapper">
        @yield('content')

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
    </main>

    <!-- BOTTOM NAV MOBILE -->
    <nav class="mobile-bottom-nav">
        @auth
            <a href="/" data-section="home">
                <i class="bi bi-house-fill"></i>
                <span>Beranda</span>
            </a>

            <a href="/services" class="{{ Request::is('services') ? 'active' : '' }}">
                <i class="bi bi-hammer"></i>
                <span>Layanan</span>
            </a>

            <a href="/reviews" class="{{ Request::is('reviews') ? 'active' : '' }}">
                <i class="bi bi-chat-quote-fill"></i>
                <span>Testimoni</span>
            </a>
        @else
            <a href="/" data-section="home">
                <i class="bi bi-house-fill"></i>
                <span>Beranda</span>
            </a>

            <a href="/#about" data-section="about">
                <i class="bi bi-info-circle-fill"></i>
                <span>Tentang Kami</span>
            </a>

            <a href="/services" class="{{ Request::is('services') ? 'active' : '' }}">
                <i class="bi bi-briefcase-fill"></i>
                <span>Layanan</span>
            </a>

            <a href="/#why-us" data-section="why-us">
                <i class="bi bi-patch-check-fill"></i>
                <span>Mengapa Kami</span>
            </a>

            <a href="/reviews" class="{{ Request::is('reviews') ? 'active' : '' }}">
                <i class="bi bi-chat-quote-fill"></i>
                <span>Testimoni</span>
            </a>
        @endauth
    </nav>

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
            btn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...';
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

        // GLOW ICON BOTTOM NAV
        document.addEventListener('DOMContentLoaded', function() {
            const wrapper = document.querySelector('.content-wrapper');
            if (!wrapper) return;

            const navLinks = document.querySelectorAll('.mobile-bottom-nav a[data-section]');
            const sections = [];

            navLinks.forEach(link => {
                const id = link.dataset.section;
                const section = document.getElementById(id);
                if (section) {
                    sections.push({
                        id,
                        link,
                        section
                    });
                }
            });

            function setActiveSection() {
                const scrollPos = wrapper.scrollTop + wrapper.clientHeight / 2;

                navLinks.forEach(l => l.classList.remove('active'));

                for (let i = sections.length - 1; i >= 0; i--) {
                    const sectionTop = sections[i].section.offsetTop;
                    if (scrollPos >= sectionTop) {
                        sections[i].link.classList.add('active');
                        break;
                    }
                }
            }

            wrapper.addEventListener('scroll', setActiveSection);
            setActiveSection();
        });

        document.addEventListener('DOMContentLoaded', () => {
            const skeleton = document.getElementById('reviewSkeleton');
            const list = document.getElementById('reviewList');

            // Simulasi loading UX (biar terasa seperti marketplace)
            setTimeout(() => {
                if (skeleton) skeleton.classList.add('d-none');
                if (list) list.classList.remove('d-none');
            }, 700);
        });
    </script>
    @stack('scripts')
</body>

</html>
