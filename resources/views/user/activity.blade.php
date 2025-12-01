@extends('layouts.dashboard')

@section('content')

<div class="card p-4">
    <div class="card-body">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Pesananku</h4>
            
            <div class="w-150px">
                <select id="yearFilter" class="form-select form-select-sm form-select-solid fw-bold">
                    @php
                        $currentYear = date('Y');
                        // Tampilkan 3 tahun ke belakang
                        $startYear = $currentYear - 2; 
                    @endphp
                    @for($y = $currentYear; $y >= $startYear; $y--)
                        <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @endfor
                </select>
            </div>
        </div>
        
        <hr class="mb-4 mt-0">

        <div class="month-slider-wrapper">
            <div class="swiper month-slider">
                <div class="swiper-wrapper">
                    @php
                        $months = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        // Gunakan angka (1-12) untuk bulan saat ini
                        $currentMonthNum = (int)date('n'); 
                    @endphp

                    @foreach($months as $num => $name)
                        <div class="swiper-slide">
                            <a href="#" class="nav-link {{ $num == $currentMonthNum ? 'active' : '' }}" 
                               data-month="{{ $num }}">
                               {{ $name }}
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
                        data-month="{{ $order->created_at->format('n') }}"
                        data-year="{{ $order->created_at->format('Y') }}"
                        style="display: none;"> 
                        
                        <div class="row w-100 m-0 align-items-center">
                            <div class="col-12 col-md-5 mb-2 mb-md-0 ps-0">
                                <h6 class="order-item-title mb-1">{{ $order->category->name ?? 'Layanan' }}</h6>
                                <span class="order-item-date">
                                    {{ $order->created_at->translatedFormat('l, d F Y') }}
                                </span>
                            </div>
                            
                            <div class="col-6 col-md-3 text-start text-md-center">
                                @php
                                    $badgeColor = 'badge-status-yellow';
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
                        Belum ada riwayat pesanan.
                    </div>
                @endforelse
            </ul>
            
            <div class="alert alert-secondary text-center mt-4 d-none" id="order-list-empty" role="alert">
                <i class="bi bi-calendar-x me-2"></i> Tidak ada pesanan di periode ini.
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
            const yearSelect = document.getElementById('yearFilter');
            const orderItems = document.querySelectorAll('.order-item');
            const emptyListAlert = document.getElementById('order-list-empty');

            // Fungsi Filter Utama
            function filterOrders() {
                // 1. Ambil Tahun yang dipilih
                const selectedYear = yearSelect.value;

                // 2. Ambil Bulan yang aktif
                const activeLink = document.querySelector('.month-slider .nav-link.active');
                // Jika tidak ada yg aktif (jarang terjadi), default ke 0
                const selectedMonth = activeLink ? activeLink.getAttribute('data-month') : 0;

                let hasData = false;

                // 3. Loop dan Filter
                orderItems.forEach(item => {
                    const itemMonth = item.getAttribute('data-month');
                    const itemYear = item.getAttribute('data-year');
                    
                    // Cek Kecocokan Bulan DAN Tahun
                    if (itemMonth === selectedMonth && itemYear === selectedYear) {
                        item.style.display = 'flex';
                        hasData = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // 4. Handle Alert Kosong
                if (hasData) {
                    emptyListAlert.classList.add('d-none');
                } else {
                    // Hanya munculkan alert jika memang ada item pesanan tapi tersembunyi semua
                    if(orderItems.length > 0) {
                        emptyListAlert.classList.remove('d-none');
                    }
                }
            }

            // --- EVENT LISTENERS ---

            // 1. Saat Tahun Diganti -> Filter ulang
            yearSelect.addEventListener('change', function() {
                filterOrders();
            });

            // 2. Saat Bulan Diklik Manual
            monthLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Update Active Class
                    monthLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    // Geser Slider (Opsional, efek visual)
                    const slide = this.closest('.swiper-slide');
                    const realIndex = parseInt(slide.getAttribute('data-swiper-slide-index'));
                    monthSwiper.slideToLoop(realIndex);

                    // Filter
                    filterOrders();
                });
            });
            
            // 3. Saat Slider Digeser (Swipe/Panah)
            monthSwiper.on('realIndexChange', function () {
                const activeSlide = monthSwiper.slides[monthSwiper.activeIndex];
                const activeLink = activeSlide.querySelector('.nav-link');
                
                if(activeLink) {
                    // Update Active Class
                    monthLinks.forEach(l => l.classList.remove('active'));
                    
                    // Karena slide di-duplicate (loop mode), kita harus cari semua link yg punya bulan sama
                    const targetMonth = activeLink.getAttribute('data-month');
                    const sameMonthLinks = document.querySelectorAll(`.month-slider .nav-link[data-month="${targetMonth}"]`);
                    sameMonthLinks.forEach(l => l.classList.add('active'));

                    // Filter
                    filterOrders();
                }
            });

            // --- INISIALISASI AWAL ---
            
            // Geser ke bulan sekarang saat load
            const initialActiveLink = document.querySelector('.month-slider .swiper-slide:not(.swiper-slide-duplicate) .nav-link.active');
            if (initialActiveLink) {
                const slideIndex = initialActiveLink.closest('.swiper-slide').getAttribute('data-swiper-slide-index');
                monthSwiper.slideToLoop(parseInt(slideIndex), 0);
            }
            
            // Jalankan filter pertama kali
            filterOrders();
        }
    });
</script>
@endpush