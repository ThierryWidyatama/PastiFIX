@extends('layouts.dashboard')

@section('content')

<div class="card p-4">
    <div class="card-body">
        
        <h4 class="fw-bold">Pesananku</h4>
        <hr class="my-3">

        <div class="month-slider-wrapper">
            <div class="swiper month-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><a href="#" class="nav-link">Januari</a></div>
                    <div class="swiper-slide"><a href="#" class="nav-link">Februari</a></div>
                    <div class="swiper-slide"><a href="#" class="nav-link">Maret</a></div>
                    <div class="swiper-slide"><a href="#" class="nav-link">April</a></div>
                    <div class="swiper-slide"><a href="#" class="nav-link">Mei</a></div>
                    <div class="swiper-slide"><a href="#" class="nav-link">Juni</a></div>
                    <div class="swiper-slide"><a href="#" class="nav-link">Juli</a></div>
                    <div class="swiper-slide"><a href="#" class="nav-link">Agustus</a></div>
                    <div class="swiper-slide"><a href="#" class="nav-link">September</a></div>
                    <div class="swiper-slide"><a href="#" class="nav-link">Oktober</a></div>
                    <div class="swiper-slide"><a href="#" class="nav-link active">November</a></div>
                    <div class="swiper-slide"><a href="#" class="nav-link">Desember</a></div>
                </div>
            </div>
            <div class="month-slider-prev month-slider-nav"><i class="bi bi-chevron-left"></i></div>
            <div class="month-slider-next month-slider-nav"><i class="bi bi-chevron-right"></i></div>
        </div>
        <div class="mt-4">
            
            <ul class="order-item-list" id="order-list-november">
                
                <li class="order-item d-flex flex-wrap align-items-center justify-content-between mb-1">
                    <div class="col-12 col-md-5 mb-2 mb-md-0">
                        <h6 class="order-item-title mb-1">Pembetulan Atap Rumah</h6>
                        <span class="order-item-date">25 November 2025</span>
                    </div>
                    <div class="col-6 col-md-3 text-start text-md-center">
                        <span class="badge-status badge-status-green">Selesai</span>
                    </div>
                    <div class="col-6 col-md-4 text-end">
                        <a href="/profil/activity/detail" class="order-item-detail">Lihat detail <i class="bi bi-chevron-right small"></i></a>
                    </div>
                </li>

                <li class="order-item d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="col-12 col-md-5 mb-2 mb-md-0">
                        <h6 class="order-item-title mb-1">Pengecatan Dinding Kamar</h6>
                        <span class="order-item-date">20 November 2025</span>
                    </div>
                    <div class="col-6 col-md-3 text-start text-md-center">
                        <span class="badge-status badge-status-yellow">On Progress</span>
                    </div>
                    <div class="col-6 col-md-4 text-end">
                        <a href="#" class="order-item-detail">Lihat detail <i class="bi bi-chevron-right small"></i></a>
                    </div>
                </li>

                <li class="order-item d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="col-12 col-md-5 mb-2 mb-md-0">
                        <h6 class="order-item-title mb-1">Pemasangan Keramik Teras</h6>
                        <span class="order-item-date">15 November 2025</span>
                    </div>
                    <div class="col-6 col-md-3 text-start text-md-center">
                        <span class="badge-status badge-status-red">Cancelled</span>
                    </div>
                    <div class="col-6 col-md-4 text-end">
                        <a href="#" class="order-item-detail">Lihat detail <i class="bi bi-chevron-right small"></i></a>
                    </div>
                </li>
            </ul>
            
            <div class="alert alert-secondary text-center mt-4 d-none" id="order-list-empty" role="alert">
                <i class="bi bi-info-circle me-2"></i> Belum ada aktivitas di bulan ini.
            </div>

        </div>

    </div>
</div>

@endsection 
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof monthSwiper !== 'undefined') {
            
            const monthLinks = document.querySelectorAll('.month-slider .nav-link');
            const orderList = document.getElementById('order-list-november');
            const emptyListAlert = document.getElementById('order-list-empty');

            // FUNGSI INI HANYA UNTUK UPDATE UI (Data & class 'active')
            function updateOrderList(selectedLink) {
                if (!selectedLink) return; // Pengaman

                // 1. Hapus 'active' dari semua link
                monthLinks.forEach(link => link.classList.remove('active'));
                
                // 2. Tambahkan 'active' ke link yg TEPAT
                selectedLink.classList.add('active');

                // 3. Tampilkan/sembunyikan data
                if (selectedLink.innerText.includes('November')) {
                    orderList.classList.remove('d-none');
                    emptyListAlert.classList.add('d-none');
                } else {
                    orderList.classList.add('d-none');
                    emptyListAlert.classList.remove('d-none');
                }
            }

            // EVENT LISTENER SAAT KLIK LINK BULAN
            monthLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Dapatkan parent slide-nya
                    const slide = this.closest('.swiper-slide');
                    // Dapatkan index ASLI dari atribut data-
                    const realIndex = parseInt(slide.getAttribute('data-swiper-slide-index'));
                    
                    // PERINTAHKAN SWIPER UNTUK SLIDE KE INDEX ITU
                    monthSwiper.slideToLoop(realIndex);
                    // JANGAN panggil updateOrderList() di sini. Biarkan event 'realIndexChange' yg urus
                });
            });
            
            // EVENT LISTENER SETELAH SLIDER BERHASIL PINDAH
            // Ini akan menjadi satu-satunya sumber yg memanggil updateOrderList
            monthSwiper.on('realIndexChange', function () {
                // Dapatkan slide yg SEKARANG aktif
                const activeSlide = monthSwiper.slides[monthSwiper.activeIndex];
                // Dapatkan link di dalam slide yg aktif itu
                const activeLink = activeSlide.querySelector('.nav-link');
                // Panggil fungsi update UI
                updateOrderList(activeLink);
            });

            // Inisialisasi tampilan awal saat halaman di-load
            const initialActiveSlide = monthSwiper.slides[monthSwiper.activeIndex];
            if (initialActiveSlide) {
                updateOrderList(initialActiveSlide.querySelector('.nav-link'));
            }
        }
    });
</script>
@endpush