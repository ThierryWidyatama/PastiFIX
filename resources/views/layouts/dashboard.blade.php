<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - PastiFIX</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

</head>
<body>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="dashboard-wrapper d-flex">
        
        <aside id="main-sidebar" class="sidebar vh-100 d-flex flex-column p-3">
            <a class="sidebar-logo text-center my-4" href="/">
                <img src="{{ asset('assets/img/logo.png') }}" alt="PastiFIX Logo" style="height: 90px;">
            </a>
            
            <ul class="nav flex-column sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('profil') ? 'active' : '' }}" href="/profil">
                        <i class="bi bi-person-fill"></i> My Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('profil/activity') ? 'active' : '' }}" href="/profil/activity">
                        <i class="bi bi-list-check"></i> My Activity
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('profil/settings') ? 'active' : '' }}" href="/profil/settings">
                        <i class="bi bi-gear-fill"></i> Account Setting
                    </a>
                </li>
            </ul>

            <ul class="nav flex-column sidebar-nav mt-auto">
                 <li class="nav-item">
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('dashboard-logout-form').submit();">
                        <i class="bi bi-box-arrow-left"></i> Sign Out
                    </a>

                    <form id="dashboard-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
                        <h2 class="header-title">User Dashboard</h2>
                        <p class="header-subtitle mb-0">Welcome to your dashboard</p>
                    </div>
                </div>

                <div class="header-user d-flex align-items-center">
                    @auth
                        <img src="{{ Auth::user()->profile_picture_url ? Storage::url(Auth::user()->profile_picture_url) : asset('assets/img/default-avatar.png') }}" 
                             alt="User Avatar" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; margin-right: 10px;">
                        
                        <span class="me-5">Hello, {{ \Illuminate\Support\Str::words(Auth::user()->name, 2, '') }}</span>
                    @else
                        <img src="{{ asset('assets/img/default-avatar.png') }}" alt="User Avatar" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; margin-right: 10px;">
                        <span class="me-5">Hello, Guest</span>
                    @endauth
                </div>
            </header>

            <div class="content-wrapper p-4">
                @yield('content')
            </div>
        </main>

    </div>

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
            // slidesPerView: 'auto', // <-- DIHAPUS
            centeredSlides: true,  // <-- INI KUNCI BUG 1
            spaceBetween: 25,
            loop: true,
            initialSlide: 10, // Default ke November (index 10)
            
            // [FIX BUG 2] Menggunakan breakpoints untuk jumlah slide
            slidesPerView: 3, // Tampilan default (mobile)
            breakpoints: {
                // Saat layar 768px (tablet)
                768: {
                    slidesPerView: 4, // Tampilkan 4 bulan
                    spaceBetween: 20
                },
                // Saat layar 992px (desktop)
                992: {
                    slidesPerView: 5, // Tampilkan 5 bulan
                    spaceBetween: 25
                }
            },

            navigation: {
                nextEl: '.month-slider-next',
                prevEl: '.month-slider-prev',
            },
        });
    </script>
    
    @stack('scripts') </body>
</html>