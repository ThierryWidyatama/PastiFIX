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
                    {{-- [FIX] Pakai variable $revenueSelectedMonth yang dikirim Controller --}}
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">Rp {{ number_format($revenueSelectedMonth, 0, ',', '.') }}</span>

                    {{-- [BONUS] Labelnya kita bikin dinamis sesuai bulan yang dipilih --}}
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">
                        Pendapatan {{ date('F', mktime(0, 0, 0, $filterMonth, 1)) }}
                    </span>
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
            <br><br>
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
            <br><br>
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
                    <span class="card-label fw-bold text-gray-800">Tren Pendapatan Harian</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">
                        Periode: {{ date('F', mktime(0, 0, 0, $filterMonth, 1)) }} {{ $filterYear }}
                    </span>
                </h3>
                
                <!-- [BARU] TOOLBAR FILTER TERPUSAT -->
                <div class="card-toolbar">
                    <!-- Form Filter (Submit ke Dashboard) -->
                    <form action="{{ route('dashboard.index') }}" method="GET" class="d-flex align-items-center gap-2" id="filterForm">
                        
                        <!-- Pilih Bulan -->
                        <select name="month" class="form-select form-select-sm form-select-solid w-125px" onchange="document.getElementById('filterForm').submit()">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $filterMonth == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endforeach
                        </select>
                        
                        <!-- Pilih Tahun -->
                        <select name="year" class="form-select form-select-sm form-select-solid w-100px" onchange="document.getElementById('filterForm').submit()">
                            @foreach(range(date('Y'), date('Y')-2) as $y)
                                <option value="{{ $y }}" {{ $filterYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>

                        <!-- Tombol Export (Link Biasa dengan Parameter) -->
                        <a href="{{ route('admin.export.revenue', ['month' => $filterMonth, 'year' => $filterYear]) }}" class="btn btn-sm btn-light-success fw-bold">
                            <i class="bi bi-file-earmark-excel me-1"></i> Export
                        </a>
                        <button type="button" class="btn btn-sm btn-light-primary fw-bold" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="bi bi-cloud-upload me-1"></i> Import Manual
                        </button>
                    </form>
                </div>
                <!-- END TOOLBAR -->
            </div>
            <div class="card-body pt-5">
                <!-- GRAFIK 1: SYSTEM -->
                <h5 class="text-gray-600 mb-3 fw-bold">💰 Pendapatan by System (Otomatis)</h5>
                <div id="kt_charts_revenue" style="height: 300px" class="mb-5"></div>
                
                <div class="separator my-10"></div>
                
                <!-- [BARU] GRAFIK 2: IMPORT -->
                <h5 class="text-gray-600 mb-3 fw-bold">📂 Pendapatan by Import (Manual/Backup)</h5>
                <div id="kt_charts_import" style="height: 300px"></div>
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

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Import Data Keuangan Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form Upload (Ini Form Asli) -->
            <form action="{{ route('admin.import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- ... (Isi body modal sama seperti sebelumnya) ... -->
                     <div class="alert alert-primary d-flex align-items-center p-4 mb-4">
                        <i class="bi bi-info-circle-fill fs-2hx text-primary me-4"></i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-primary">Panduan Import</h4>
                            <span>Unduh template, isi data sesuai format, lalu upload kembali. Data akan <strong>ditambahkan</strong> ke grafik.</span>
                        </div>
                    </div>
                    
                    <div class="mb-3 text-center">
                        <a href="{{ route('admin.import.template') }}" class="btn btn-outline-primary btn-sm border-dashed">
                            <i class="bi bi-download me-1"></i> Download Template Excel
                        </a>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Upload File Excel</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv" required>
                    </div>
                </div>

                <!-- Footer dengan 2 Aksi -->
                <div class="modal-footer d-flex justify-content-between">
                    
                    <!-- [BARU] Tombol Reset (Form Terpisah) -->
                    <!-- Kita pakai trik button type="button" yang men-trigger form delete di luar -->
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmReset()">
                        <i class="bi bi-trash me-1"></i> Reset Data Bulan Ini
                    </button>

                    <div>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload & Proses</button>
                    </div>
                </div>
            </form>

            <!-- [BARU] Form Reset Tersembunyi -->
            <form id="reset-import-form" action="{{ route('admin.import.reset') }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
                <!-- Kirim parameter filter saat ini -->
                <input type="hidden" name="month" value="{{ $filterMonth }}">
                <input type="hidden" name="year" value="{{ $filterYear }}">
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // === GRAFIK 1: PENDAPATAN SYSTEM ===
    var elementRevenue = document.getElementById('kt_charts_revenue');
    if (elementRevenue) {
        // [FIX] Ganti $dailyRevenue jadi $dailyRevenueSystem
        var daysInMonth = {{ count($dailyRevenueSystem) }}; 
        var categories = Array.from({length: daysInMonth}, (_, i) => (i + 1).toString());

        var optionsRevenue = {
            series: [{
                name: 'By System',
                // [FIX] Ganti variable data
                data: @json(array_values($dailyRevenueSystem)) 
            }],
            chart: { fontFamily: 'inherit', type: 'area', height: 350, toolbar: { show: false } },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            xaxis: {
                categories: categories,
                axisBorder: { show: false },
                axisTicks: { show: false },
                title: { text: 'Tanggal' }
            },
            yaxis: { labels: { formatter: function (value) { return value.toLocaleString('id-ID'); } } },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.9, stops: [0, 90, 100] } },
            colors: ['#F1416C'],
            tooltip: { y: { formatter: function (val) { return "Rp " + val.toLocaleString('id-ID'); } } }
        };
        new ApexCharts(elementRevenue, optionsRevenue).render();
    }

    // === GRAFIK 2: PENDAPATAN IMPORT ===
    var elementImport = document.getElementById('kt_charts_import');
    if (elementImport) {
        var optionsImport = {
            series: [{ 
                name: 'By Import', 
                // [FIX] Gunakan dailyRevenueImport
                data: @json(array_values($dailyRevenueImport)) 
            }],
            chart: { fontFamily: 'inherit', type: 'area', height: 300, toolbar: { show: false } },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            xaxis: {
                // Label tanggal sama aja kaya system
                categories: @json(array_keys($dailyRevenueSystem)), 
                axisBorder: { show: false }, axisTicks: { show: false }
            },
            yaxis: { labels: { formatter: function (value) { return value.toLocaleString('id-ID'); } } },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.9, stops: [0, 90, 100] } },
            colors: ['#009EF7'], // Warna Biru
            tooltip: { y: { formatter: function (val) { return "Rp " + val.toLocaleString('id-ID'); } } }
        };
        new ApexCharts(elementImport, optionsImport).render();
    }

    // === GRAFIK 2: STATUS PESANAN (INTERAKTIF) ===
    var elementStatus = document.getElementById('kt_charts_status');

    if (elementStatus) {
        var optionsStatus = {
            series: @json(array_values($statusCounts)), // Urutan data: [Selesai, Proses, Pending, Batal]
            chart: {
                type: 'donut',
                fontFamily: 'inherit',
                height: 350,
                // [BARU] Tambahkan Event Listener Klik
                events: {
                    dataPointSelection: function(event, chartContext, config) {
                        // Ambil Index Slice yang diklik (0, 1, 2, atau 3)
                        var index = config.dataPointIndex;
                        
                        // Mapping Index ke Status Database
                        // Urutan harus SAMA PERSIS dengan array 'labels' di bawah
                        var statusMap = [
                            'FINISHED',             // Index 0: Selesai
                            'ALL_PROCESS',          // Index 1: [FIX] Proses (Gabungan)
                            'PENDING_ADMIN_REVIEW', // Index 2: Pending
                            'ALL_CANCELLED'         // Index 3: [FIX] Batal (Gabungan)
                        ];

                        // Ambil status target
                        var targetStatus = statusMap[index];
                        
                        // Redirect ke halaman pesanan dengan filter
                        if (targetStatus) {
                            window.location.href = "{{ route('admin.orders.index') }}?status=" + targetStatus;
                        }
                    }
                }
            },
            labels: ['Selesai', 'Proses', 'Pending', 'Batal'], // Urutan Label
            colors: ['#50cd89', '#009ef7', '#ffc700', '#f1416c'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            legend: { position: 'bottom' },
            dataLabels: { enabled: false },
            // Ubah kursor jadi pointer biar tau bisa diklik
            tooltip: {
                style: {
                    fontSize: '12px'
                },
                onDatasetHover: {
                    highlightDataSeries: true,
                }
            }
        };

        var chartStatus = new ApexCharts(elementStatus, optionsStatus);
        chartStatus.render();
    }

    function confirmReset() {
        if (confirm('PERINGATAN: Apakah Anda yakin ingin menghapus SEMUA data import manual untuk bulan yang sedang dipilih? Data tidak bisa dikembalikan.')) {
            document.getElementById('reset-import-form').submit();
        }
    }
</script>
@endpush