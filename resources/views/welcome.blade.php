@extends('visitor.template.layout')

@section('slider')
    <style>
        /* Add this style section to your template */
        .slider-container {
            position: relative;
            width: 100%;
            /* This maintains exact 1600:800 ratio (800/1600 = 0.5) */
            padding-bottom: 50%;
            overflow: hidden;
        }

        .my-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .slide-item {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
        }

        /* For very small screens, adjust minimum height */
        @media (max-width: 576px) {
            .slider-container {
                min-height: 250px;
            }
        }
    </style>

    <div class="slider-container">
        <div class="my-slider">
            <div class="slide-item" style="background-image: url('{{ asset('media/stock/1600x800/img-1.jpg') }}');">
            </div>
            <div class="slide-item" style="background-image: url('{{ asset('media/stock/1600x800/img-2.jpg') }}');">
            </div>
            <div class="slide-item" style="background-image: url('{{ asset('media/stock/1600x800/img-3.jpg') }}');">
            </div>
        </div>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100%;">
            <div class="controls d-flex justify-content-between px-4" id="customize-controls"
                aria-label="Carousel Navigation" tabindex="0">
                <div class="prev btn btn-icon btn-sm btn-outline" aria-controls="customize" tabindex="-1"
                    data-controls="prev">
                    <i class="ki-duotone ki-arrow-left fs-1 text-white">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <div class="next btn btn-icon btn-sm btn-outline" aria-controls="customize" tabindex="-1"
                    data-controls="next">
                    <i class="ki-duotone ki-arrow-right fs-1 text-white">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
    <script>
        var slider = tns({
            container: '.my-slider',
            "items": 1,
            "controlsContainer": "#customize-controls",
            "autoplay": false,
            "autoplayTimeout": 1000,
            "swipeAngle": false,
            "speed": 400,
            "nav": false,
        });
    </script> <!--begin::Wrapper-->
@endsection



@section('toolbar')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-start">
            <!--begin::Toolbar container-->
            <div class="d-flex flex-column flex-row-fluid">
                <!--begin::Toolbar wrapper=-->
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <!--begin::Page title-->
                    <div class="page-title me-5">
                        <!--begin::Title-->
                        <div class="page-heading d-flex text-white fw-bold fs-2x flex-column justify-content-center my-0">
                            Selamat Datang
                            <!--begin::Description-->
                            <span class="page-desc text-gray-600 fw-semibold fs-6 pt-3 pb-10 pb-md-0">
                                JDIH merupakan singkatan dari Jaringan Dokumentasi dan Informasi Hukum. JDIH
                                adalah suatu sistem informasi yang menyediakan informasi hukum yang terkait
                                dengan peraturan perundang-undangan yang berlaku di suatu negara. JDIH ini
                                biasanya dikelola oleh suatu lembaga pemerintah yang berwenang dalam bidang
                                hukum.
                            </span>
                            <!--end::Description-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                </div>
                <!--end::Toolbar wrapper=-->
            </div>
            <!--end::Toolbar container=-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
@endsection

@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="row g-5 g-xl-8">
                <!--begin::Search Card-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="fw-bold fs-3 mb-1">Dokumen apa yang ingin anda
                                cari?</span>
                        </h3>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Search Form-->
                        <form id="search-form" class="mb-7">
                            <div class="row g-5 mb-5">
                                <div class="col-md-10">
                                    <label class="fs-6 fw-semibold mb-2">Kata Kunci</label>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="Masukan kata kunci" />
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-dark d-flex align-items-center">
                                        <i class="ki-outline ki-magnifier fs-2 me-2"></i>
                                        Cari
                                    </button>
                                </div>
                            </div>

                            <div class="row g-5">
                                <div class="col-md-3">
                                    <label class="fs-6 fw-semibold mb-2">Nomor Peraturan</label>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="Nomor Peraturan" />
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-semibold mb-2">Tahun Peraturan</label>
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-placeholder="Pilih Tahun">
                                        <option></option>
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                        <option value="2021">2021</option>
                                        <option value="2020">2020</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-semibold mb-2">Jenis Dokumen</label>
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-placeholder="Pilih Tipe Dokumen">
                                        <option></option>
                                        <option value="1">Undang-Undang</option>
                                        <option value="2">Peraturan Pemerintah</option>
                                        <option value="3">Peraturan Presiden</option>
                                        <option value="4">Keputusan Menteri</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-semibold mb-2">Status</label>
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-placeholder="Pilih Status">
                                        <option></option>
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                        <option value="pending">Tertunda</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <!--end::Search Form-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Search Card-->
            </div>
            <!--begin::Row-->
            <div class="row g-5 g-xl-8 pt-5">
                <!--begin::Regulation Information-->
                <div class="mb-1 mb-xl-3">
                    <!--begin::Card header-->
                    <div class="pt-0 pb-5">
                        <h3 class="mb-3">
                            <span class="fw-bolder fs-2tx text-dark">Informasi </span>
                            <span class="fw-bolder fs-2tx text-primary">Peraturan</span>
                        </h3>
                        <p class="fs-6 text-gray-600">Berbagai Peraturan telah dirilis ada di sini.
                            Mulai dari yang terbaru hingga terpopuler</p>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Nav Menu-->
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-4 mb-4">
                        <ul class="nav nav-pills mb-0" id="peraturanTab" role="tablist">
                            <li class="nav-item w-100 w-md-auto mb-2 mb-md-0">
                                <a class="rounded-pill d-flex align-items-center text-primary text-active-white text-bold fs-5 gap-2 btn btn-sm btn-color-primary btn-active btn-active-primary px-4 me-1 active w-100 w-md-auto justify-content-center"
                                    id="terbaru-tab" data-bs-toggle="pill" href="#terbaru">
                                    <i class="ki-outline ki-time fs-2 me-2"></i>
                                    Peraturan Terbaru
                                </a>
                            </li>
                            <li class="nav-item w-100 w-md-auto mb-2 mb-md-0">
                                <a class="rounded-pill d-flex align-items-center text-primary text-active-white text-bold fs-5 gap-2 btn btn-sm btn-color-primary btn-active btn-active-primary px-4 me-1 w-100 w-md-auto justify-content-center"
                                    id="terpopuler-tab" data-bs-toggle="pill" href="#terpopuler">
                                    <i class="ki-outline ki-eye fs-2 me-2"></i>
                                    Peraturan Terpopuler
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--end::Nav Menu-->
                    <!--begin::Tab Content-->
                    <div class="tab-content" id="peraturanTabContent">
                        <!-- Peraturan Terbaru -->
                        <div class="tab-pane fade show active" id="terbaru" role="tabpanel"
                            aria-labelledby="terbaru-tab">
                            <div class="row g-5">
                                <!-- Dummy Card 1 -->
                                <!--begin::Col-->
                                <div class="col-md-6 col-lg-4">
                                    <div
                                        class="card h-100 shadow-sm transition-all hover-scale-105 hover-shadow-lg hover-elevate-up border border-hover-primary cursor-pointer">
                                        <!--begin::Header-->
                                        <div class="card-header py-3 px-3 bg-primary">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-light-primary fw-semibold px-2">2025</span>
                                                <span class="badge badge-light-info fw-semibold px-2">PANDANGAN
                                                    UMUM FRAKSI</span>
                                                <span class="badge badge-success fw-semibold px-2">Berlaku</span>
                                            </div>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Body-->
                                        <div class="card-body p-8 d-flex flex-column">
                                            <div class="d-flex align-items-center mb-5">
                                                <i class="ki-outline ki-calendar-8 fs-3 text-gray-500 me-3"></i>
                                                <span class="text-gray-700">14 Januari 2025</span>
                                                <span class="mx-3 text-gray-400">•</span>
                                                <span class="text-gray-700">Admin JDIH</span>
                                            </div>

                                            <h3 class="fs-2 fw-bold text-dark mb-4">PANDANGAN UMUM FRAKSI
                                                Nomor - Tahun 2025</h3>

                                            <p class="text-gray-700 fs-6 mb-7 flex-grow-1">Terhadap
                                                Rancangan Peraturan Daerah tentang Penyelenggaraan
                                                Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat
                                            </p>

                                            <div class="d-flex align-items-center mt-auto pt-4 border-top">
                                                <button type="button"
                                                    class="btn btn-light-primary btn-sm rounded-pill me-3 px-4 hover-scale-110">
                                                    <i class="ki-outline ki-arrow-down fs-3 me-1"></i>
                                                    25x Diunduh
                                                </button>
                                                <button type="button"
                                                    class="btn btn-light-primary btn-sm rounded-pill px-4 hover-scale-110">
                                                    <i class="ki-outline ki-eye fs-3 me-1"></i>
                                                    123x Dilihat
                                                </button>
                                            </div>
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-6 col-lg-4">
                                    <div
                                        class="card h-100 shadow-sm transition-all hover-scale-105 hover-shadow-lg hover-elevate-up border border-hover-primary cursor-pointer">
                                        <!--begin::Header-->
                                        <div class="card-header py-3 px-3 bg-primary">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-light-primary fw-semibold px-2">2025</span>
                                                <span class="badge badge-light-info fw-semibold px-2">PANDANGAN
                                                    UMUM FRAKSI</span>
                                                <span class="badge badge-success fw-semibold px-2">Berlaku</span>
                                            </div>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Body-->
                                        <div class="card-body p-8 d-flex flex-column">
                                            <div class="d-flex align-items-center mb-5">
                                                <i class="ki-outline ki-calendar-8 fs-3 text-gray-500 me-3"></i>
                                                <span class="text-gray-700">14 Januari 2025</span>
                                                <span class="mx-3 text-gray-400">•</span>
                                                <span class="text-gray-700">Admin JDIH</span>
                                            </div>

                                            <h3 class="fs-2 fw-bold text-dark mb-4">PANDANGAN UMUM FRAKSI
                                                Nomor - Tahun 2025</h3>

                                            <p class="text-gray-700 fs-6 mb-7 flex-grow-1">Terhadap
                                                Rancangan Peraturan Daerah tentang Penyelenggaraan Kearsipan
                                            </p>

                                            <div class="d-flex align-items-center mt-auto pt-4 border-top">
                                                <button type="button"
                                                    class="btn btn-light-primary btn-sm rounded-pill me-3 px-4 hover-scale-110">
                                                    <i class="ki-outline ki-arrow-down fs-3 me-1"></i>
                                                    52x Diunduh
                                                </button>
                                                <button type="button"
                                                    class="btn btn-light-primary btn-sm rounded-pill px-4 hover-scale-110">
                                                    <i class="ki-outline ki-eye fs-3 me-1"></i>
                                                    102x Dilihat
                                                </button>
                                            </div>
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-md-6 col-lg-4">
                                    <div
                                        class="card h-100 shadow-sm transition-all hover-scale-105 hover-shadow-lg hover-elevate-up border border-hover-primary cursor-pointer">
                                        <!--begin::Header-->
                                        <div class="card-header py-3 px-3 bg-primary">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-light-primary fw-semibold px-2">2025</span>
                                                <span class="badge badge-light-info fw-semibold px-2">PANDANGAN
                                                    UMUM FRAKSI</span>
                                                <span class="badge badge-success fw-semibold px-2">Berlaku</span>
                                            </div>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Body-->
                                        <div class="card-body p-8 d-flex flex-column">
                                            <div class="d-flex align-items-center mb-5">
                                                <i class="ki-outline ki-calendar-8 fs-3 text-gray-500 me-3"></i>
                                                <span class="text-gray-700">14 Januari 2025</span>
                                                <span class="mx-3 text-gray-400">•</span>
                                                <span class="text-gray-700">Admin JDIH</span>
                                            </div>

                                            <h3 class="fs-2 fw-bold text-dark mb-4">PANDANGAN UMUM FRAKSI
                                                Nomor - Tahun 2025</h3>

                                            <p class="text-gray-700 fs-6 mb-7 flex-grow-1">Terhadap
                                                Rancangan Peraturan Daerah tentang Penyelenggaraan
                                                Kepariwisataan</p>

                                            <div class="d-flex align-items-center mt-auto pt-4 border-top">
                                                <button type="button"
                                                    class="btn btn-light-primary btn-sm rounded-pill me-3 px-4 hover-scale-110">
                                                    <i class="ki-outline ki-arrow-down fs-3 me-1"></i>
                                                    0x Diunduh
                                                </button>
                                                <button type="button"
                                                    class="btn btn-light-primary btn-sm rounded-pill px-4 hover-scale-110">
                                                    <i class="ki-outline ki-eye fs-3 me-1"></i>
                                                    101x Dilihat
                                                </button>
                                            </div>
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>

                        <!-- Peraturan Terpopuler -->
                        <div class="tab-pane fade" id="terpopuler" role="tabpanel" aria-labelledby="populer-tab">
                            <div class="row g-5">
                                <!--begin::Col-->
                                <div class="col-md-6 col-lg-4">
                                    <div
                                        class="card h-100 shadow-sm transition-all hover-scale-105 hover-shadow-lg hover-elevate-up border border-hover-primary cursor-pointer">
                                        <!--begin::Header-->
                                        <div class="card-header py-3 px-3 bg-primary">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-light-primary fw-semibold px-2">2025</span>
                                                <span class="badge badge-light-info fw-semibold px-2">PANDANGAN
                                                    UMUM FRAKSI</span>
                                                <span class="badge badge-success fw-semibold px-2">Berlaku</span>
                                            </div>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Body-->
                                        <div class="card-body p-8 d-flex flex-column">
                                            <div class="d-flex align-items-center mb-5">
                                                <i class="ki-outline ki-calendar-8 fs-3 text-gray-500 me-3"></i>
                                                <span class="text-gray-700">14 Januari 2025</span>
                                                <span class="mx-3 text-gray-400">•</span>
                                                <span class="text-gray-700">Admin JDIH</span>
                                            </div>

                                            <h3 class="fs-2 fw-bold text-dark mb-4">PANDANGAN UMUM FRAKSI
                                                Nomor - Tahun 2025</h3>

                                            <p class="text-gray-700 fs-6 mb-7 flex-grow-1">Terhadap
                                                Rancangan Peraturan Daerah tentang Penyelenggaraan
                                                Kepariwisataan</p>

                                            <div class="d-flex align-items-center mt-auto pt-4 border-top">
                                                <button type="button"
                                                    class="btn btn-light-primary btn-sm rounded-pill me-3 px-4 hover-scale-110">
                                                    <i class="ki-outline ki-arrow-down fs-3 me-1"></i>
                                                    0x Diunduh
                                                </button>
                                                <button type="button"
                                                    class="btn btn-light-primary btn-sm rounded-pill px-4 hover-scale-110">
                                                    <i class="ki-outline ki-eye fs-3 me-1"></i>
                                                    101x Dilihat
                                                </button>
                                            </div>
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-6 col-lg-4">
                                    <div
                                        class="card h-100 shadow-sm transition-all hover-scale-105 hover-shadow-lg hover-elevate-up border border-hover-primary cursor-pointer">
                                        <!--begin::Header-->
                                        <div class="card-header py-3 px-3 bg-primary">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-light-primary fw-semibold px-2">2025</span>
                                                <span class="badge badge-light-info fw-semibold px-2">PANDANGAN
                                                    UMUM FRAKSI</span>
                                                <span class="badge badge-success fw-semibold px-2">Berlaku</span>
                                            </div>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Body-->
                                        <div class="card-body p-8 d-flex flex-column">
                                            <div class="d-flex align-items-center mb-5">
                                                <i class="ki-outline ki-calendar-8 fs-3 text-gray-500 me-3"></i>
                                                <span class="text-gray-700">14 Januari 2025</span>
                                                <span class="mx-3 text-gray-400">•</span>
                                                <span class="text-gray-700">Admin JDIH</span>
                                            </div>

                                            <h3 class="fs-2 fw-bold text-dark mb-4">PANDANGAN UMUM FRAKSI
                                                Nomor - Tahun 2025</h3>

                                            <p class="text-gray-700 fs-6 mb-7 flex-grow-1">Terhadap
                                                Rancangan Peraturan Daerah tentang Penyelenggaraan
                                                Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat
                                            </p>

                                            <div class="d-flex align-items-center mt-auto pt-4 border-top">
                                                <button type="button"
                                                    class="btn btn-light-primary btn-sm rounded-pill me-3 px-4 hover-scale-110">
                                                    <i class="ki-outline ki-arrow-down fs-3 me-1"></i>
                                                    25x Diunduh
                                                </button>
                                                <button type="button"
                                                    class="btn btn-light-primary btn-sm rounded-pill px-4 hover-scale-110">
                                                    <i class="ki-outline ki-eye fs-3 me-1"></i>
                                                    123x Dilihat
                                                </button>
                                            </div>
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                    </div>
                    <!--end::Tab Content-->
                </div>
                <div class="d-flex flex-end">
                    <a class="btn btn-primary btn-sm" href="#">
                        Selengkapnya
                        <i class="ki-outline ki-arrow-right fs-2 ms-2"></i>
                    </a>
                </div>
                <!--end::Regulation Information-->
            </div>

            <div class="row g-5 g-xl-8 pt-5">
                <!--begin::Card header-->
                <div class="pt-0 pb-1">
                    <h3 class="mb-3">
                        <span class="fw-bolder fs-2tx text-dark">Jenis </span>
                        <span class="fw-bolder fs-2tx text-warning">Dokumen Pilihan</span>
                    </h3>
                    <p class="fs-6 text-gray-600">Berikut jenis-jenis dokumen pilihan yang tersedia</p>
                </div>
                <!--end::Card header-->
                <div class="row g-5 mt-0">
                    <div class="col-xl-3 col-md-6 d-flex align-items-stretch">
                        <div class="card d-flex flex-column w-100 position-relative hover-scale">
                            <a href="#" class="position-absolute top-0 bottom-0 left-0 right-0 w-100"></a>
                            <div class="card-body flex-grow-1 text-center">
                                <i class="ki-duotone ki-document fs-5tx text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <h4 class="pt-4">Peraturan Daerah</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex align-items-stretch">
                        <div class="card d-flex flex-column w-100 position-relative hover-scale">
                            <a href="#" class="position-absolute top-0 bottom-0 left-0 right-0 w-100"></a>
                            <div class="card-body flex-grow-1 text-center">
                                <i class="ki-duotone ki-document fs-5tx text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <h4 class="pt-4">Peraturan Gubernur</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex align-items-stretch">
                        <div class="card d-flex flex-column w-100 position-relative hover-scale">
                            <a href="#" class="position-absolute top-0 bottom-0 left-0 right-0 w-100"></a>
                            <div class="card-body flex-grow-1 text-center">
                                <i class="ki-duotone ki-document fs-5tx text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <h4 class="pt-4">Peraturan Gubernur</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex align-items-stretch">
                        <div class="card d-flex flex-column w-100 position-relative hover-scale">
                            <a href="#" class="position-absolute top-0 bottom-0 left-0 right-0 w-100"></a>
                            <div class="card-body flex-grow-1 text-center">
                                <i class="ki-duotone ki-document fs-5tx text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <h4 class="pt-4">Intruksi Gubernur</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-end">
                    <a class="btn btn-warning btn-sm" href="#">
                        Selengkapnya
                        <i class="ki-outline ki-arrow-right fs-2 ms-2"></i>
                    </a>
                </div>
            </div>

            <div class="row g-4 pt-3 pt-md-10">
                <!-- Left column - takes full width on small screens, 5/12 on medium, 4/12 on xl -->
                <div class="col-12 col-md-5 col-xl-4">
                    <div class="pt-0 pb-1">
                        <h3 class="mb-3">
                            <span class="fw-bolder fs-2tx text-dark">Kata </span>
                            <span class="fw-bolder fs-2tx text-danger">Sambutan</span>
                        </h3>
                        <div class="fs-5 fs-md-4">
                            <p>
                                Selamat datang di Website JDIH
                            </p>
                            <p>
                                Kami dengan bangga mempersembahkan platform ini sebagai pusat informasi dan dokumentasi
                                hukum yang lengkap dan terkini. Website ini dirancang untuk memudahkan akses masyarakat
                                terhadap
                                berbagai peraturan perundang-undangan, dan informasi hukum lainnya yang berlaku.
                            </p>
                            <p>
                                Dengan adanya JDIH ini, kami berharap dapat memberikan kontribusi nyata dalam meningkatkan
                                pemahaman dan kesadaran hukum di kalangan masyarakat, serta mendukung transparansi dan
                                akuntabilitas pemerintahan.
                            </p>
                            <p>
                                Terima kasih atas kunjungan Anda.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right column - takes full width on small screens, 7/12 on medium, 8/12 on xl -->
                <div class="col-12 col-md-7 col-xl-8 ps-md-4 ps-xl-5 mt-3 mt-md-0">
                    <div class="card">
                        <div class="card-body p-2 p-md-3">
                            <!-- Responsive iframe using ratio utility -->
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/l3ovXkjxqpQ?si=YjWA3uYGUtu4roMv"
                                    title="YouTube video player"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
@endsection

@section('script')
@endsection
