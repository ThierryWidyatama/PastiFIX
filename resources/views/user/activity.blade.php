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

            // --- 1. FUNGSI FILTER UTAMA (UPDATED) ---
            // Terima parameter opsional untuk "Paksa" bulan/tahun tertentu
            function filterOrders(forceMonth = null, forceYear = null) {

                // A. Tentukan Tahun
                let selectedYear = forceYear;
                if (!selectedYear) {
                    selectedYear = yearSelect ? yearSelect.value : "{{ date('Y') }}";
                }

                // B. Tentukan Bulan
                let selectedMonth = forceMonth;
                if (!selectedMonth) {
                    // Cari link yang punya class 'active'
                    // Kita cari di slide yang sedang aktif view-nya
                    let activeLink = document.querySelector('.month-slider .swiper-slide-active .nav-link');

                    // Fallback kalau swiper belum ready, cari global active
                    if (!activeLink) {
                        activeLink = document.querySelector('.month-slider .nav-link.active');
                    }

                    selectedMonth = activeLink ? activeLink.getAttribute('data-month') : "{{ (int)date('n') }}";
                }

                // Debugging (Cek di Console F12 kalau masih error)
                // console.log("Filtering: Bulan " + selectedMonth + ", Tahun " + selectedYear);

                let hasData = false;

                // C. Loop & Filter
                orderItems.forEach(item => {
                    const itemMonth = item.getAttribute('data-month');
                    const itemYear = item.getAttribute('data-year');

                    if (itemMonth == selectedMonth && itemYear == selectedYear) {
                        item.style.display = 'flex';
                        hasData = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // D. Handle Alert Kosong
                if (hasData) {
                    emptyListAlert.classList.add('d-none');
                } else {
                    // Tampilkan alert hanya jika user punya data pesanan (tapi di bulan lain)
                    // Kalau orderItems.length 0 (user baru), biarkan view blade yg nanganin
                    if(orderItems.length > 0) {
                        emptyListAlert.classList.remove('d-none');
                    }
                }
            }

            // --- 2. EVENT LISTENERS ---

            if(yearSelect) {
                yearSelect.addEventListener('change', function() {
                    filterOrders();
                });
            }

            monthLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Reset UI Active
                    monthLinks.forEach(l => l.classList.remove('active'));

                    // Set Klik Active (Cari semua link dgn bulan yg sama karena slide diduplikasi loop)
                    const targetMonth = this.getAttribute('data-month');
                    const sameMonthLinks = document.querySelectorAll(`.month-slider .nav-link[data-month="${targetMonth}"]`);
                    sameMonthLinks.forEach(l => l.classList.add('active'));

                    // Geser Slider
                    const slide = this.closest('.swiper-slide');
                    const realIndex = parseInt(slide.getAttribute('data-swiper-slide-index'));
                    monthSwiper.slideToLoop(realIndex);

                    // Panggil filter tanpa paksaan (baca dari active class)
                    filterOrders(targetMonth, null);
                });
            });

            // Listener Saat Slider Digeser (Swipe)
            monthSwiper.on('realIndexChange', function () {
                const activeIndex = monthSwiper.realIndex;
                const activeSlide = document.querySelector(`.month-slider .swiper-slide[data-swiper-slide-index="${activeIndex}"]:not(.swiper-slide-duplicate)`);

                if(activeSlide) {
                    const link = activeSlide.querySelector('.nav-link');
                    if(link) {
                        const targetMonth = link.getAttribute('data-month');

                        // Update UI Active
                        monthLinks.forEach(l => l.classList.remove('active'));
                        document.querySelectorAll(`.month-slider .nav-link[data-month="${targetMonth}"]`)
                                .forEach(l => l.classList.add('active'));

                        // Filter
                        filterOrders(targetMonth, null);
                    }
                }
            });

            // --- 3. INISIALISASI AWAL (THE FIX) ---

            // Data PHP (Server Time)
            const serverMonthIndex = {{ (int)date('n') - 1 }}; // 0-11
            const serverMonthData = "{{ (int)date('n') }}";   // 1-12
            const serverYear = "{{ date('Y') }}";

            // A. Set Dropdown Tahun
            if(yearSelect) yearSelect.value = serverYear;

            // B. Set UI Active (Visual)
            monthLinks.forEach(l => l.classList.remove('active'));
            document.querySelectorAll(`.month-slider .nav-link[data-month="${serverMonthData}"]`)
                    .forEach(l => l.classList.add('active'));

            // C. Geser Slider
            setTimeout(() => {
                monthSwiper.slideToLoop(serverMonthIndex, 0);
            }, 10);

            // D. [KUNCINYA] JALANKAN FILTER PAKSA DENGAN DATA SERVER
            // Kita tidak peduli slider lagi nunjuk mana, pokoknya filter pakai Data Server.
            filterOrders(serverMonthData, serverYear);
        }
    });
</script>
@endpush
