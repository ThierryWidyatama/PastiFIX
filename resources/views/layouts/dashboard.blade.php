<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - PastiFIX</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</head>

<body>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- MOBILE HEADER -->
    <header class="mobile-header">
        <div class="mobile-header-left">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
            <span>PastiFIX</span>
        </div>

        <div class="mobile-header-right dropdown">
            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ Auth::user()->profile_picture_url ? Storage::url(Auth::user()->profile_picture_url) : asset('assets/img/default-avatar.png') }}"
                    class="mobile-avatar">
            </a>

            <ul class="dropdown-menu dropdown-menu-end mobile-profile-dropdown shadow">
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
    </header>

    <div class="dashboard-wrapper d-flex">

        <aside id="main-sidebar" class="sidebar vh-100 d-flex flex-column p-3">
            <a class="sidebar-logo text-center my-4" href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="PastiFIX Logo" style="height: 90px;">
            </a>

            <ul class="nav flex-column sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('profil') ? 'active' : '' }}" href="/profil">
                        <i class="bi bi-person-fill"></i> Profil Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('profil/activity') ? 'active' : '' }}" href="/profil/activity">
                        <i class="bi bi-list-check"></i> Aktifitas Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('profil/settings') ? 'active' : '' }}" href="/profil/settings">
                        <i class="bi bi-gear-fill"></i> Pengaturan Akun
                    </a>
                </li>
            </ul>

            <ul class="nav flex-column sidebar-nav mt-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"
                        onclick="event.preventDefault(); document.getElementById('dashboard-logout-form').submit();">
                        <i class="bi bi-box-arrow-left"></i> Keluar
                    </a>

                    <form id="dashboard-logout-form" action="{{ route('logout') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </aside>

        <main class="main-content flex-grow-1">
            <header class="header-dashboard d-flex justify-content-between align-items-center p-4">

                <div class="d-flex align-items-center">
                    <button class="hamburger-btn me-3" id="hamburger-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <h2 class="header-title">Dashboard Pengguna</h2>
                        <p class="header-subtitle mb-0">Selamat datang di dashboard anda.</p>
                    </div>
                </div>

                <div class="header-user d-flex align-items-center">
                    @auth
                        <img src="{{ Auth::user()->profile_picture_url ? Storage::url(Auth::user()->profile_picture_url) : asset('assets/img/default-avatar.png') }}"
                            alt="User Avatar" class="rounded-circle"
                            style="width: 45px; height: 45px; object-fit: cover; margin-right: 10px;">

                        <span class="me-5">Halo, {{ \Illuminate\Support\Str::words(Auth::user()->name, 2, '') }}</span>
                    @else
                        <img src="{{ asset('assets/img/default-avatar.png') }}" alt="User Avatar" class="rounded-circle"
                            style="width: 45px; height: 45px; object-fit: cover; margin-right: 10px;">
                        <span class="me-5">Halo, Pengguna</span>
                    @endauth
                </div>
            </header>

            <div class="content-wrapper p-4">
                @yield('content')
            </div>
        </main>

    </div>

    <!-- MOBILE BOTTOM NAV -->
    <nav class="mobile-bottom-nav">
        <a href="/" class="{{ Request::is('/') ? 'active' : '' }}">
            <i class="bi bi-house-fill"></i>
            <span>Home</span>
        </a>

        <a href="/profil" class="{{ Request::is('profil') ? 'active' : '' }}">
            <i class="bi bi-person-fill"></i>
            <span>Profile</span>
        </a>

        <a href="/profil/activity" class="{{ Request::is('profil/activity*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>Aktivitas</span>
        </a>

        <a href="/profil/settings" class="{{ Request::is('profil/settings*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i>
            <span>Pengaturan</span>
        </a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // [FIX 5] JS UNTUK TOGGLE SIDEBAR RESPONSIVE
        document.getElementById('hamburger-toggle').addEventListener('click', function() {
            document.getElementById('main-sidebar').classList.toggle('is-open');
            document.getElementById('sidebar-overlay').classList.toggle('is-open');
        });

        // [FIX 5] JS UNTUK MENUTUP SIDEBAR SAAT KLIK OVERLAY
        document.getElementById('sidebar-overlay').addEventListener('click', function() {
            document.getElementById('main-sidebar').classList.remove('is-open');
            document.getElementById('sidebar-overlay').classList.remove('is-open');
        });


        // [REVISI BUG 1 & 2] Inisialisasi Swiper untuk Slider Bulan
        var monthSwiper = new Swiper('.month-slider', {
            centeredSlides: true,
            loop: true,
            spaceBetween: 20,

            slidesPerView: 1, // ⬅️ DEFAULT MOBILE

            breakpoints: {
                551: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 24
                },
                992: {
                    slidesPerView: 5,
                    spaceBetween: 25
                }
            },

            navigation: {
                nextEl: '.month-slider-next',
                prevEl: '.month-slider-prev',
            },
        });


        window.setLoading = function(btn) {
            if (!btn) return;

            // Simpan teks asli tombol di atribut data
            if (!btn.hasAttribute('data-original-text')) {
                btn.setAttribute('data-original-text', btn.innerHTML);
            }

            // Ubah jadi spinner
            btn.disabled = true;
            btn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';
        };

        // [GLOBAL HELPER] Fungsi Reset Button (Opsional, buat jaga-jaga)
        window.resetLoading = function(btn) {
            if (!btn) return;
            btn.disabled = false;
            if (btn.hasAttribute('data-original-text')) {
                btn.innerHTML = btn.getAttribute('data-original-text');
            }
        };

        // [OTOMATIS] Tangani semua form biasa (type="submit")
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('submit', function(e) {
                const form = e.target;
                const btn = form.querySelector('button[type="submit"]');

                // Jika form valid dan tombol ketemu, jalankan loading
                if (btn && form.checkValidity()) {
                    window.setLoading(btn);

                    // Safety: Balikin tombol setelah 15 detik (jaga-jaga koneksi putus)
                    setTimeout(() => window.resetLoading(btn), 15000);
                }
            });
        });
    </script>

    @stack('scripts')

</body>

</html>
