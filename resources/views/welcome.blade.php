@extends('layouts.landing')

@section('title', 'Solusi Renovasi Rumah Anda')

@section('content')

<section id="home">
    <div class="container text-white">
        <h1>Selamat Datang di website PastiFIX!</h1>
        <p class="lead my-4">Kami ada untuk menyelesaikan masalah bangunan dirumah anda!</p>
        <a href="#service" class="btn btn-brand btn-lg fw-medium">Mulai Sekarang</a>
    </div>
</section>

<section id="about" class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img src="{{ asset('assets/img/about.png') }}" class="img-fluid rounded" alt="Tentang PastiFIX">
            </div>
            <div class="col-lg-6 ps-lg-5 mt-5 mt-lg-0">
                <div class="about-content">
                    <h2 class="section-title">Apa itu PastiFIX?</h2>
                    <p class="section-subtitle text-secondary">PastiFIX adalah platform layanan renovasi dan perbaikan rumah yang menghubungkan Anda dengan tenaga profesional terpercaya.
                        Kami membantu mulai dari perbaikan kecil hingga renovasi besar dengan proses yang transparan dan mudah.</p>
                </div>
                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="icon-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%;">
                                <i class="bi bi-tools fs-2" style="color: #bf3131;"></i>
                            </div>
                            <h6 class="fw-bold">Profesional</h6>
                            <p class="small text-muted">Tim ahli dan berpengalaman.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="icon-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%;">
                                <i class="bi bi-shield-check fs-2" style="color: #bf3131;"></i>
                            </div>
                            <h6 class="fw-bold">Terpercaya</h6>
                            <p class="small text-muted">Garansi kualitas pengerjaan.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                           <div class="icon-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%;">
                                <i class="bi bi-stopwatch fs-2" style="color: #bf3131;"></i>
                            </div>
                            <h6 class="fw-bold">Tepat Waktu</h6>
                            <p class="small text-muted">Pengerjaan sesuai jadwal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION: CARA PEMESANAN -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="section-subtitle text-danger fw-bold">- Mudah & Cepat -</h3>
            <h1 class="section-title fw-bold">Cara Pesan Jasa</h1>
        </div>

        <div class="row g-4 justify-content-center position-relative">
            <!-- Garis Penghubung (Hanya di Desktop) -->
            <div class="d-none d-lg-block position-absolute top-50 start-0 w-100 translate-middle-y border-top border-2 border-danger border-dashed z-n1" style="height: 0;"></div>

            <!-- Step 1 -->
            <div class="col-md-6 col-lg-3 text-center">
                <div class="bg-white p-4 rounded shadow-sm h-100 position-relative">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded-circle fs-3 fw-bold mb-3" style="width: 60px; height: 60px; border: 4px solid #fff; box-shadow: 0 0 0 2px #fe1a1a;">1</div>
                    <h5 class="fw-bold">Pilih Layanan</h5>
                    <p class="text-muted small">Cari masalah rumah Anda di daftar layanan kami.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="col-md-6 col-lg-3 text-center">
                <div class="bg-white p-4 rounded shadow-sm h-100 position-relative">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded-circle fs-3 fw-bold mb-3" style="width: 60px; height: 60px; border: 4px solid #fff; box-shadow: 0 0 0 2px #fe1a1a;">2</div>
                    <h5 class="fw-bold">Atur Jadwal</h5>
                    <p class="text-muted small">Tentukan lokasi dan waktu survei yang Anda inginkan.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-md-6 col-lg-3 text-center">
                <div class="bg-white p-4 rounded shadow-sm h-100 position-relative">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded-circle fs-3 fw-bold mb-3" style="width: 60px; height: 60px; border: 4px solid #fff; box-shadow: 0 0 0 2px #fe1a1a;">3</div>
                    <h5 class="fw-bold">Survei & Deal</h5>
                    <p class="text-muted small">Mandor datang, cek kerusakan, dan sepakati harga final.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="col-md-6 col-lg-3 text-center">
                <div class="bg-white p-4 rounded shadow-sm h-100 position-relative">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle fs-3 fw-bold mb-3" style="width: 60px; height: 60px; border: 4px solid #fff; box-shadow: 0 0 0 2px #198754;">4</div>
                    <h5 class="fw-bold">Selesai & Bayar</h5>
                    <p class="text-muted small">Pengerjaan selesai, bayar aman lewat aplikasi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="service" class="section-padding bg-light">
    <div class="container text-center">
        <h2 class="section-title">Layanan Kami</h2>
        <p class="section-subtitle text-secondary mx-auto" style="max-width: 600px;">Beragam solusi terbaik untuk kebutuhan renovasi dan perbaikan rumah Anda.</p>
        <div class="row g-4 mt-5">
            <div class="col-lg-3 col-md-6">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <img src="{{ asset('assets/img/service1.jpg') }}" alt="Service 1">
                        </div>
                        <div class="flip-card-back">
                            <h5 class="fw-bold">Renovasi Atap</h5>
                            <p>Perbaikan dan pemasangan atap bocor dengan material terbaik.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <img src="{{ asset('assets/img/service2.jpg') }}" alt="Service 2">
                        </div>
                        <div class="flip-card-back">
                            <h5 class="fw-bold">Pengecatan Ulang</h5>
                            <p>Jasa pengecatan interior dan eksterior untuk rumah Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                 <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <img src="{{ asset('assets/img/service3.jpg') }}" alt="Service 3">
                        </div>
                        <div class="flip-card-back">
                            <h5 class="fw-bold">Instalasi Listrik</h5>
                            <p>Pemasangan dan perbaikan instalasi listrik yang aman.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <img src="{{ asset('assets/img/service4.jpg') }}" alt="Service 4">
                        </div>
                        <div class="flip-card-back">
                            <h5 class="fw-bold">Desain Interior</h5>
                            <p>Wujudkan interior impian Anda bersama desainer kami.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <a href="{{ route('services.index') }}" class="btn btn-outline-brand rounded-pill px-4 py-2 fw-medium">
                Lihat Semua Layanan <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

<section id="why-us" class="section-padding">
    <div class="container">
        <div class="text-center">
             <h2 class="section-title">Mengapa Kami?</h2>
        </div>
        <div class="row align-items-center mt-5">
            <div class="col-lg-6">
                <img src="{{ asset('assets/img/section4.png') }}" class="img-fluid rounded" alt="Why Us">
            </div>
            <div class="col-lg-6 ps-lg-5 mt-5 mt-lg-0">
                <div class="icon-box mb-4">
                    <div class="icon"><i class="bi bi-check-circle"></i></div>
                    <div>
                        <h5 class="fw-bold">Kualitas Terjamin</h5>
                        <p class="text-muted">Kami menggunakan material terbaik dan dikerjakan oleh tenaga profesional untuk hasil yang maksimal dan tahan lama.</p>
                    </div>
                </div>
                 <div class="icon-box mb-4">
                    <div class="icon"><i class="bi bi-cash-coin"></i></div>
                    <div>
                        <h5 class="fw-bold">Harga Kompetitif</h5>
                        <p class="text-muted">Dapatkan penawaran harga terbaik yang transparan tanpa biaya tersembunyi, sesuai dengan anggaran Anda.</p>
                    </div>
                </div>
                 <div class="icon-box">
                    <div class="icon"><i class="bi bi-headset"></i></div>
                    <div>
                        <h5 class="fw-bold">Konsultasi Gratis</h5>
                        <p class="text-muted">Tim kami siap membantu Anda merencanakan renovasi impian. Hubungi kami untuk konsultasi tanpa biaya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- STATS BAR -->
<section class="stats-bar text-white">
    <div class="container">
         <div class="row align-items-center">
             <div class="col-lg-4 text-center text-lg-start mb-4 mb-lg-0">
                 <h4 class="fw-bold">Statistik Perusahaan Kami</h4>
             </div>
             <div class="col-lg-8">
                 <div class="row text-center">

                     <!-- SATISFACTION -->
                     <div class="col-md-4">
                         <!-- [DINAMIS] Pakai variable $satisfactionRate -->
                         <h2 class="fw-bold">{{ $satisfactionRate }}%</h2>
                         <p class="fw-medium">Tingkat Kepuasan</p>
                     </div>

                     <!-- ACTIVE USERS -->
                     <div class="col-md-4">
                         <!-- [DINAMIS] Pakai variable $activeUsers -->
                         <h2 class="fw-bold">{{ $activeUsers }}</h2>
                         <p class="fw-medium">Pengguna Aktif</p>
                     </div>

                     <!-- TEAM MEMBERS -->
                     <div class="col-md-4">
                         <!-- [DINAMIS] Pakai variable $teamCount -->
                         <h2 class="fw-bold">{{ $teamCount }}+</h2>
                         <p class="fw-medium">Anggota Tim</p>
                     </div>

                 </div>
             </div>
         </div>
    </div>
</section>

<!-- SECTION 5: TESTIMONI KLASIK -->
<section id="testimoni" class="section-padding bg-light">
    <div class="container text-center mb-5">
        <h3 class="section-subtitle text-danger fw-bold">- Ulasan Pengguna -</h3>
        <h1 class="section-title fw-bold">Apa Kata Mereka?</h1>
    </div>

    <div class="container">
        <!-- Swiper Container -->
        <div class="swiper testimonial-slider-classic">
            <div class="swiper-wrapper py-3"> <!-- Padding y biar shadow gak kepotong -->

                @forelse($reviews as $review)
                    <div class="swiper-slide">
                        <div class="testi-card-classic">
                            <!-- 1. Foto Profil -->
                            <img src="{{ $review->user->profile_picture_url ? Storage::url($review->user->profile_picture_url) : asset('assets/img/default-avatar.png') }}"
                                 class="testi-profile-img"
                                 alt="{{ $review->user->name }}">

                            <!-- 2. Nama -->
                            <h5 class="testi-name">{{ $review->user->name }}</h5>

                            <!-- 3. Rating Bintang -->
                            <div class="testi-stars">
                                @php
                                    $avgRating = ceil(($review->rating_mandor + $review->rating_service) / 2);
                                @endphp
                                @for($i=1; $i<=5; $i++)
                                    <i class="bi bi-star{{ $i <= $avgRating ? '-fill' : '' }}"></i>
                                @endfor
                            </div>

                            <!-- 4. Komentar -->
                            <p class="testi-comment">
                                "{{ \Illuminate\Support\Str::limit($review->comment, 120, '...') }}"
                            </p>

                            <!-- 5. Tanggal -->
                            <span class="testi-date">{{ $review->created_at->format('d F Y') }}</span>
                        </div>
                    </div>
                @empty
                    <!-- Fallback -->
                    <div class="swiper-slide">
                        <div class="testi-card-classic">
                            <img src="{{ asset('assets/img/logo.png') }}" class="testi-profile-img" alt="Admin">
                            <h5 class="testi-name">Admin PastiFIX</h5>
                            <div class="testi-stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testi-comment">"Belum ada ulasan. Jadilah yang pertama!"</p>
                            <span class="testi-date">Hari Ini</span>
                        </div>
                    </div>
                @endforelse

            </div>

            <!-- Pagination Dots -->
            <div class="swiper-pagination mt-4 position-relative"></div>
        </div>

        <!-- Tombol Lihat Semua -->
        <div class="text-center mt-5">
            <a href="{{ route('reviews.index') }}" class="btn btn-outline-brand rounded-pill px-4 py-2 fw-medium">
                Lihat Semua Ulasan <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

@endsection
