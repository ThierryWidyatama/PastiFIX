@extends('layouts.landing')

@section('content')

<section id="home">
    <div class="container text-white">
        <h1>Selamat Datang di website PastiFIX!</h1>
        <p class="lead my-4">Kami ada untuk menyelesaikan masalah bangunan dirumah anda!</p>
        <a href="#service" class="btn btn-brand btn-lg fw-medium">Get Started</a>
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
                    <p class="section-subtitle text-secondary">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium.</p>
                </div>
                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="icon-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%;">
                                <i class="bi bi-tools fs-2" style="color: #EECB2F;"></i>
                            </div>
                            <h6 class="fw-bold">Profesional</h6>
                            <p class="small text-muted">Tim ahli dan berpengalaman.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="icon-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%;">
                                <i class="bi bi-shield-check fs-2" style="color: #EECB2F;"></i>
                            </div>
                            <h6 class="fw-bold">Terpercaya</h6>
                            <p class="small text-muted">Garansi kualitas pengerjaan.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                           <div class="icon-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 50%;">
                                <i class="bi bi-stopwatch fs-2" style="color: #EECB2F;"></i>
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

<section id="service" class="section-padding bg-light">
    <div class="container text-center">
        <h2 class="section-title">Our Service</h2>
        <p class="section-subtitle text-secondary mx-auto" style="max-width: 600px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
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
    </div>
</section>

<section id="why-us" class="section-padding">
    <div class="container">
        <div class="text-center">
             <h2 class="section-title">Why Us?</h2>
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
<section class="stats-bar text-white">
    <div class="container">
         <div class="row align-items-center">
             <div class="col-lg-4 text-center text-lg-start mb-4 mb-lg-0">
                 <h4 class="fw-bold">Our company stats</h4>
             </div>
             <div class="col-lg-8">
                 <div class="row text-center">
                     <div class="col-md-4">
                         <h2 class="fw-bold">99%</h2>
                         <p class="fw-medium">Satisfaction</p>
                     </div>
                      <div class="col-md-4">
                         <h2 class="fw-bold">32K</h2>
                         <p class="fw-medium">Active users</p>
                     </div>
                      <div class="col-md-4">
                         <h2 class="fw-bold">25+</h2>
                         <p class="fw-medium">Team members</p>
                     </div>
                 </div>
             </div>
         </div>
    </div>
</section>

<section id="testimoni" class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Users Rating</h2>
        </div>
        
        <div class="swiper testimonial-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <img src="{{ asset('assets/img/user1.jpeg') }}" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;" alt="User 1">
                        <h6 class="fw-bold">Andi Pratama</h6>
                        <div class="rating-stars mb-3">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted">"Pengerjaannya sangat rapi dan cepat. Komunikasi dengan mandor juga lancar. Sangat direkomendasikan!"</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <img src="{{ asset('assets/img/user2.jpg') }}" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;" alt="User 2">
                        <h6 class="fw-bold">Siti Aminah</h6>
                        <div class="rating-stars mb-3">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                        </div>
                        <p class="text-muted">"Hasilnya melebihi ekspektasi saya. Terima kasih PastiFIX sudah membuat dapur saya jadi lebih modern."</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <img src="{{ asset('assets/img/user3.png') }}" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;" alt="User 3">
                        <h6 class="fw-bold">Budi Santoso</h6>
                        <div class="rating-stars mb-3">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted">"Proses dari awal pemesanan sampai selesai sangat mudah dan transparan. Pelayanan yang luar biasa."</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <img src="{{ asset('assets/img/user3.png') }}" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;" alt="User 3">
                        <h6 class="fw-bold">Iwak Santoso</h6>
                        <div class="rating-stars mb-3">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted">"Proses dari awal pemesanan sampai selesai sangat mudah dan transparan. Pelayanan yang luar biasa."</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <img src="{{ asset('assets/img/user3.png') }}" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;" alt="User 3">
                        <h6 class="fw-bold">Kuceng Handoko Santoso</h6>
                        <div class="rating-stars mb-3">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted">"Proses dari awal pemesanan sampai selesai sangat mudah dan transparan. Pelayanan yang luar biasa."</p>
                    </div>
                </div>
            </div>
             <div class="swiper-pagination"></div>
        </div>

    </div>
</section>

@endsection