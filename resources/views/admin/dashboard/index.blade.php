@extends('admin.template.layout')

@section('content')

<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    
    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
        <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #F1416C; background-image:url('assets/media/patterns/vector-1.png');">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Pendapatan</span>
                </div>
            </div>
            <div class="card-body d-flex align-items-end pt-0">
                <div class="d-flex align-items-center flex-column mt-3 w-100">
                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                        <div class="bg-white rounded h-8px" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
        <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #50CD89; background-image:url('assets/media/patterns/vector-1.png');">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</span>
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Pendapatan Bulan Ini</span>
                </div>
            </div>
            <div class="card-body d-flex align-items-end pt-0">
                <div class="d-flex align-items-center flex-column mt-3 w-100">
                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                        <div class="bg-white rounded h-8px" role="progressbar" style="width: 70%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
        <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #009EF7;">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $totalOrders }}</span>
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Pesanan Masuk</span>
                </div>
                <div class="card-toolbar">
                    <i class="bi bi-cart-check-fill fs-1 text-white"></i>
                </div>
            </div>
             <div class="card-body d-flex align-items-end pt-0">
                 <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-white text-primary fw-bold w-100 mt-3">Lihat Semua</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
        <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #FFC700;">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $mandorCount }}</span>
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Mandor Terdaftar</span>
                </div>
                <div class="card-toolbar">
                    <i class="bi bi-person-workspace fs-1 text-white"></i>
                </div>
            </div>
             <div class="card-body d-flex align-items-end pt-0">
                 <a href="{{ route('mandor.index') }}" class="btn btn-sm btn-white text-warning fw-bold w-100 mt-3">Kelola Mandor</a>
            </div>
        </div>
    </div>

</div>

<div class="row g-5 g-xl-10">
    <div class="col-xl-8">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Tren Pendapatan</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Statistik Tahun {{ date('Y') }}</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                <div id="kt_charts_revenue" style="height: 350px"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Distribusi Pesanan</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Status Terkini</span>
                </h3>
            </div>
            <div class="card-body pt-5 d-flex align-items-center justify-content-center">
                <div id="kt_charts_status" style="height: 350px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // === GRAFIK 1: PENDAPATAN BULANAN (SAMA SEPERTI SEBELUMNYA) ===
    var elementRevenue = document.getElementById('kt_charts_revenue');
    if (elementRevenue) {
        var optionsRevenue = {
            series: [{ name: 'Pendapatan (Rp)', data: @json(array_values($monthlyRevenue)) }],
            chart: { fontFamily: 'inherit', type: 'area', height: 350, toolbar: { show: false } },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'], axisBorder: { show: false }, axisTicks: { show: false } },
            yaxis: { labels: { formatter: function (value) { return value.toLocaleString('id-ID'); } } },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.9, stops: [0, 90, 100] } },
            colors: ['#F1416C'],
            tooltip: { y: { formatter: function (val) { return "Rp " + val.toLocaleString('id-ID'); } } }
        };
        var chartRevenue = new ApexCharts(elementRevenue, optionsRevenue);
        chartRevenue.render();
    }

    // === GRAFIK 2: STATUS PESANAN (SAMA SEPERTI SEBELUMNYA) ===
    var elementStatus = document.getElementById('kt_charts_status');
    if (elementStatus) {
        var optionsStatus = {
            series: @json(array_values($statusCounts)),
            chart: { type: 'donut', fontFamily: 'inherit', height: 350 },
            labels: ['Selesai', 'Proses', 'Pending', 'Batal'],
            colors: ['#50cd89', '#009ef7', '#ffc700', '#f1416c'],
            plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', formatter: function (w) { return w.globals.seriesTotals.reduce((a, b) => a + b, 0); } } } } } },
            legend: { position: 'bottom' },
            dataLabels: { enabled: false }
        };
        var chartStatus = new ApexCharts(elementStatus, optionsStatus);
        chartStatus.render();
    }
</script>
@endpush