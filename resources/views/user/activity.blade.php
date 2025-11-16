@extends('layouts.dashboard')

@section('content')

<div class="card p-4">
    <div class="card-body">
        
        <h4 class="fw-bold">Pesananku</h4>
        <hr class="my-3">

        <div class="month-slider-wrapper">
            <div class="swiper month-slider">
                <div class="swiper-wrapper">
                    @php
                        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        $currentMonth = \Carbon\Carbon::now()->translatedFormat('F');
                    @endphp

                    @foreach($months as $index => $month)
                        <div class="swiper-slide">
                            <a href="#" class="nav-link {{ $month == $currentMonth ? 'active' : '' }}" 
                               data-month="{{ $month }}">
                               {{ $month }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="month-slider-prev month-slider-nav"><i class="bi bi-chevron-left"></i></div>
            <div class="month-slider-next month-slider-nav"><i class="bi bi-chevron-right"></i></div>
        </div>
        <div class="mt-4">
            
            <ul class="order-item-list" id="order-list-container">
                @forelse($orders as $order)
                    <li class="order-item flex-wrap align-items-center justify-content-between mb-3" 
                        data-month="{{ $order->created_at->translatedFormat('F') }}"
                        style="display: none;"> <div class="row w-100 m-0 align-items-center">
                            <div class="col-12 col-md-5 mb-2 mb-md-0 ps-0">
                                <h6 class="order-item-title mb-1">{{ $order->category->name ?? 'Layanan' }}</h6>
                                <span class="order-item-date">
                                    {{ $order->created_at->translatedFormat('l, d F Y') }}
                                </span>
                            </div>
                            
                            <div class="col-6 col-md-3 text-start text-md-center">
                                @php
                                    $badgeColor = 'badge-status-yellow'; // Default pending/process
                                    $statusText = str_replace('_', ' ', $order->status);
                                    
                                    if(in_array($order->status, ['COMPLETED_PENDING_PAYMENT', 'FINISHED'])) {
                                        $badgeColor = 'badge-status-green';
                                    } elseif(in_array($order->status, ['REJECTED_BY_ADMIN', 'REJECTED_BY_MANDOR', 'CANCELLED'])) {
                                        $badgeColor = 'badge-status-red';
                                    }
                                @endphp
                                <span class="badge-status {{ $badgeColor }}">
                                    {{ ucwords(strtolower($statusText)) }}
                                </span>
                            </div>
                            
                            <div class="col-6 col-md-4 text-end pe-0">
                                <a href="{{ route('profil.activity.detail', $order->id) }}" class="order-item-detail">
                                    Lihat detail <i class="bi bi-chevron-right small"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                @empty
                    <div class="alert alert-info text-center w-100">
                        Belum ada pesanan sama sekali. Yuk <a href="{{ route('services.index') }}">pesan jasa sekarang!</a>
                    </div>
                @endforelse
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
        // Pastikan Swiper sudah ada
        if (typeof monthSwiper !== 'undefined') {
            
            const monthLinks = document.querySelectorAll('.month-slider .nav-link');
            const orderItems = document.querySelectorAll('.order-item');
            const emptyListAlert = document.getElementById('order-list-empty');

            // Fungsi Inti: Filter List Berdasarkan Bulan
            function filterOrders(selectedMonthName) {
                let hasData = false;

                // 1. Loop semua item order
                orderItems.forEach(item => {
                    // Ambil bulan dari data-attribute item
                    const itemMonth = item.getAttribute('data-month');
                    
                    // Bandingkan dengan bulan yang dipilih
                    if (itemMonth === selectedMonthName) {
                        item.style.display = 'flex'; // Tampilkan (gunakan flex karena ada d-flex)
                        hasData = true;
                    } else {
                        item.style.display = 'none'; // Sembunyikan
                    }
                });

                // 2. Tampilkan/Sembunyikan Alert Kosong
                if (hasData) {
                    emptyListAlert.classList.add('d-none');
                } else {
                    if(orderItems.length > 0) { // Hanya tampilkan jika user sebenarnya punya order (tapi di bulan lain)
                        emptyListAlert.classList.remove('d-none');
                    }
                }
            }

            // Fungsi untuk update UI Slider (Active Class) & Panggil Filter
            function updateActiveMonth(selectedLink) {
                if (!selectedLink) return;

                // UI: Hapus active lama, tambah active baru
                monthLinks.forEach(link => link.classList.remove('active'));
                selectedLink.classList.add('active');

                // Logic: Filter data
                const monthName = selectedLink.getAttribute('data-month');
                filterOrders(monthName);
            }

            // Event Listener: Klik Bulan Manual
            monthLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const slide = this.closest('.swiper-slide');
                    const realIndex = parseInt(slide.getAttribute('data-swiper-slide-index'));
                    monthSwiper.slideToLoop(realIndex); // Geser slider
                    // Note: Kita ga perlu panggil updateActiveMonth di sini
                    // karena slideToLoop akan memicu event 'realIndexChange' di bawah
                });
            });
            
            // Event Listener: Slider Bergeser (Otomatis/Manual)
            monthSwiper.on('realIndexChange', function () {
                const activeSlide = monthSwiper.slides[monthSwiper.activeIndex];
                const activeLink = activeSlide.querySelector('.nav-link');
                updateActiveMonth(activeLink);
            });

            // Inisialisasi Awal (Saat halaman dimuat)
            // Kita cari slide yang punya class 'active' dari PHP (bulan sekarang)
            // Karena swiper loop, slide 'active' mungkin ada di index yg aneh.
            // Jadi kita cari berdasarkan text bulan sekarang.
            
            // @php $currentMonthJS = \Carbon\Carbon::now()->translatedFormat('F'); @endphp
            // const currentMonthName = "{{ $currentMonthJS }}";
            
            // Cara lebih aman: cari elemen .nav-link.active yang dirender PHP
            const initialActiveLink = document.querySelector('.month-slider .swiper-slide:not(.swiper-slide-duplicate) .nav-link.active');
            
            if (initialActiveLink) {
                // Geser slider ke bulan ini
                const slideIndex = initialActiveLink.closest('.swiper-slide').getAttribute('data-swiper-slide-index');
                monthSwiper.slideToLoop(parseInt(slideIndex), 0); // 0ms speed biar instan
                
                // Filter data
                filterOrders(initialActiveLink.getAttribute('data-month'));
            } else {
                // Fallback (misal Januari)
                updateActiveMonth(monthLinks[0]);
            }
        }
    });
</script>
@endpush