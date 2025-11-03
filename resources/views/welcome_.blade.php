@extends('public_template.layout')

@section('css')
    <style>
        #kt_slider_thumbnails .tns-nav-active {
            border: 1px black solid;
        }
    </style>
@endsection


@section('content')
    <div class="w-100 d-none d-sm-block" style="">


        <div class="tns position-relative" style="direction: ltr">
            <div class="position-absolute top-o h-100 w-100 z-index-1 opacity-50"
                style="background-image: url('{{ asset('img/hero-gradient-white.png') }}');background-repeat: no-repeat; background-size: cover;">
            </div>
            {{--            <div class="position-absolute top-25 mx-md-20 mx-sm-auto z-index-1 w-md-50 w-75"> --}}
            {{--                <h1 class="fs-md-3tx fs-2hx text-black ps-20">SELAMAT DATANG DI WEBSITE <span class="text-danger">JDIH PROV --}}
            {{--                        JATENG</span></h1> --}}
            {{--            </div> --}}
            <!--begin::Slider-->
            <div class="" data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000"
                data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-controls="false" data-tns-nav="false"
                data-tns-nav-position="bottom" data-tns-items="1" data-tns-center="false" data-tns-mouse-drag="true">
                @foreach ($sliders as $slider)
                    <!--begin::Item-->
                    <img src="{{ asset($slider->foto) }}" alt="" class="object-fit-cover"
                        style="object-position:  right">
                    <!--end::Item-->
                @endforeach
            </div>
            <!--end::Slider-->
        </div>

    </div>
    <div class="bg-vector-1">
        <div class="container-xxl pt-10 pb-4 pt-md-4 pb-md-4">
            <div class="content flex-row-fluid">
                @include('public_template.cari_dokumen_form')
            </div>
        </div>
    </div>

    <div class="">
        <div class="container-xxl py-4 my-10">
            <div class="content flex-row-fluid">
                <div class="text-left">
                    <h1 class="d-inline-block fs-2hx">
                        Informasi <span class="text-primary">Peraturan</span>
                    </h1>
                    <p>Berbagai Peraturan telah dirilis ada di sini. Mulai dari yang terbaru hingga terpopuler</p>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                            <li class="nav-item">
                                <a class="d-flex align-items-center active text-primary text-active-white text-bold fs-4 gap-2 btn btn-sm btn-color-primary btn-active btn-active-primary px-4 me-1"
                                    data-bs-toggle="tab" href="#kt_tab_pane_7">
                                    <i class="fa fa-clock fs-4"></i>
                                    <span>Peraturan Terbaru</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex align-items-center text-primary text-active-white text-bold fs-4 gap-2 btn btn-sm btn-color-primary btn-active btn-active-primary px-4 me-1"
                                    data-bs-toggle="tab" href="#kt_tab_pane_8">
                                    <i class="fa fa-eye fs-4"></i>
                                    <span>Peraturan Terpopuler</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="py-2">
                        <div class="d-flex flex-end">
                            <a class="btn btn-primary btn-sm" id="buttonTerbaru" style="display: none"
                                href="{{ '#' }}">
                                Selengkapnya
                                <i class="fa fa-arrow-right-long ms-2"></i>
                            </a>
                        </div>
                        <div class="d-flex flex-end">
                            <a class="btn btn-primary btn-sm" id="buttonTerpopuler" style="display: none"
                                href="{{ '#' }}">
                                Selengkapnya
                                <i class="fa fa-arrow-right-long ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="kt_tab_pane_7" role="tabpanel">
                        <div class="row g-8">
                            @foreach ($latest_docs as $item)
                                @php
                                    $kategori = isset($item['get_tipe_dokumen'])
                                        ? $item->get_tipe_dokumen->name
                                        : $item['Jenis'];
                                    $judul = $item['judul'];
                                    if ($kategori && $item['nomor_peraturan']) {
                                        $judul =
                                            $kategori .
                                            ' Nomor ' .
                                            $item['nomor_peraturan'] .
                                            ' Tahun ' .
                                            $item['tahun_terbit'];
                                    }
                                @endphp
                                @include('public_template.produk_hukum_card', [
                                    'id' => $item->id,
                                    'judul' => $judul,
                                    'tentang' => $item->tentang,
                                    'tahun' => $item->tahun_terbit,
                                    'created_at' => \Carbon\Carbon::parse($item->created_at)->translatedFormat(
                                        'd F Y'),
                                    'hit_see' => number_format($item->hit_see) . 'x Dilihat',
                                    'hit_download' => number_format($item->hit_download ?? 0) . 'x Diunduh',
                                    'jenis' => $item->get_tipe_dokumen->name,
                                    'link' => $item->link,
                                ])
                            @endforeach
                        </div>

                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
                        <div class="row g-8">
                            @foreach ($most_viewed_docs as $item)
                                @include('public_template.produk_hukum_card', [
                                    'id' => $item->id,
                                    'judul' => $item->judul,
                                    'tentang' => $item->tentang,
                                    'tahun' => $item->tahun_terbit,
                                    'created_at' => \Carbon\Carbon::parse($item->created_at)->translatedFormat(
                                        'd F Y'),
                                    'hit_see' => number_format($item->hit_see) . 'x Dilihat',
                                    'hit_download' => number_format($item->hit_download ?? 0) . 'x Diunduh',
                                    'jenis' => $item->get_tipe_dokumen->name,
                                    'link' => $item->link,
                                ])
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>



    <div class="">
        <div class="container-xxl py-4 my-10">
            <div class="content flex-row-fluid">
                <div class="text-left">
                    <h1 class="d-inline-block fs-2hx">
                        Jenis <span class="text-warning">Dokumen Pilihan</span>
                    </h1>
                    <p>Berikut jenis-jenis dokumen pilihan yang tersedia:</p>
                </div>
                <div class="d-flex flex-end py-4">
                    <a class="btn btn-warning btn-sm" href="{{ '#' }}">
                        Selengkapnya
                        <i class="fa fa-arrow-right-long ms-2"></i>
                    </a>
                </div>
                <div class="row g-8">
                    @foreach ($tipe_dokumens as $tipe_dokumen)
                        @include('public_template.kategori_dokumen_card', [
                            'id' => $tipe_dokumen->id,
                            'name' => $tipe_dokumen->name,
                            'singkatan' => $tipe_dokumen->singkatan,
                        ])
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <div class="bg-grid-fade">
        <div class="container-xxl py-4 my-10">
            <div class="content flex-row-fluid">
                <div class="row mt-10">
                    <div class="col-md-4 text-left">
                        <h1 class="fs-2hx">
                            Kata <span class="text-danger">Sambutan</span>
                        </h1>
                        <div class="fs-4">
                            <p>
                                Selamat datang di Website JDIH Prov. Jawa Tengah
                            </p>
                            <p>
                                Kami dengan bangga mempersembahkan platform ini sebagai pusat informasi dan dokumentasi
                                hukum
                                yang lengkap dan terkini. Website ini dirancang untuk memudahkan akses masyarakat terhadap
                                berbagai peraturan perundang-undangan, dan informasi hukum lainnya yang berlaku di Provinsi
                                Jawa
                                Tengah.
                            </p>
                            <p>
                                Dengan adanya JDIH ini, kami berharap dapat memberikan kontribusi nyata dalam meningkatkan
                                pemahaman dan kesadaran hukum di kalangan masyarakat, serta mendukung transparansi dan
                                akuntabilitas pemerintahan.
                                <br>
                            </p>
                            <p>
                                Terima kasih atas kunjungan Anda.
                            </p>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <iframe src="https://www.youtube.com/embed/l3ovXkjxqpQ" title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen="" class="w-100 h-lg-500px h-300px"></iframe>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="">
        <div class="container-xxl py-4 my-10">
            <div class="row">
                <div class="col-md-12 flex-row-fluid">
                    <div class="text-left">
                        <h1 class="fs-2hx">
                            Informasi <span class="text-success">Produk dan Layanan</span>
                        </h1>
                        <p>Berikut jenis-jenis produk dan layanan yang tersedia:</p>
                    </div>
                    <div class="d-flex flex-end py-4">
                        <button class="btn btn-success btn-sm">
                            Selengkapnya
                            <i class="fa fa-arrow-right-long ms-2"></i>
                        </button>
                    </div>
                    <div class="row g-8">
                        {{-- @foreach ($all_layanan_terkait as $key => $item)
                            <div class="col-xl-4 col-md-6 d-flex align-items-stretch ">
                                <div class="card d-flex flex-column w-100 border-3 border-success">
                                    <div class="card-body flex-grow-1 d-flex flex-column gap-4 align-items-center">
                                        @if ($item->logo)
                                            <img src="{{ asset($item->logo) }}" alt="" class="w-25">
                                        @else
                                            <i class="{{ $item->icon }} fs-4tx"></i>
                                        @endif
                                        <h1>{{ $item->name }}</h1>
                                        <p class="text-muted truncate-vertical-4 flex-grow-1">{{ $item->description }}</p>
                                        <a href="{{ $item->url }}" class="btn btn-dark w-100">
                                            <i class="ki-duotone ki-eye fs-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            Lihat Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach --}}

                    </div>

                </div>

            </div>

        </div>
    </div>

    <div class="bg-wave-abstract">
        <div class="container-xxl py-4 my-10">
            <div class="row">
                <div class="col-md-5">
                    <div class="text-left">
                        <h1 class="fs-2hx">
                            Infografis <span class="text-info">Terbaru</span>
                        </h1>
                        <p>Berikut Infografis Terbaru Kami</p>
                        <div class="d-flex flex-column gap-4 align-items-center">
                            <div class="tns" style="direction: ltr">
                                <!--begin::Slider-->
                                <div class="my-slider" data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false"
                                    data-tns-speed="2000" data-tns-autoplay="true" data-tns-autoplay-timeout="18000"
                                    data-tns-items="1" data-tns-center="true" data-tns-slide-by="page"
                                    data-tns-nav-container="#kt_slider_thumbnails" data-tns-nav-as-thumbnails="true"
                                    data-tns-controls="false">
                                    <!--begin::Item-->
                                    {{-- @foreach ($latest_infografis->images->sortBy('order') as $key => $item)
                                        <div class="text-center px-2 py-2">
                                            <img src="{{ asset($item->path) }}"
                                                class="mw-100 h-md-500px h-200px object-fit-cover rounded-2"
                                                alt="" />
                                        </div>
                                    @endforeach --}}
                                    <!--end::Item-->
                                </div>
                                <!--end::Slider-->

                            </div>
                            <div class="d-flex gap-2 align-items-center" id="kt_slider_thumbnails">
                                {{-- @foreach ($latest_infografis->images->sortBy('order') as $key => $item)
                                    <img src="{{ asset($item->path) }}" class="h-50px w-50px mb-3 rounded cursor-pointer"
                                        alt="" />
                                @endforeach --}}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-7">
                    <div class="text-left">
                        <h1 class="fs-2hx">
                            Berita <span class="text-info">Terbaru</span>
                        </h1>
                        <p>Berita berikut dapat diakses untuk memberikan wawasan dan pengetahuan yang lebih dalam</p>
                    </div>
                    <div class="d-flex flex-end py-4 ">
                        <a href="{{ '#' }}" class="btn btn-info btn-sm">
                            Selengkapnya
                            <i class="fa fa-arrow-right-long ms-2"></i>
                        </a>
                    </div>
                    <div class="row g-4 align-items-stretch" id="news_container">
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="">
        <div class="container-xxl py-4 my-10">
            <div class="text-left">
                <h1 class="fs-2hx">
                    Sosial <span class="text-primary">Media</span>
                </h1>
                <p>Berikut sosial media kami untuk informasi lebih banyak</p>
                <div class="content flex-row-fluid">
                    <div class="row g-8">
                        <div class="col-md-4 text-center text-lg-center">
                            <h1 class="d-inline-block mb-10">
                                FACEBOOK
                            </h1>
                            <iframe class="mt-5 rounded-4"
                                src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fprofile.php%3Fid%3D100067561222468&tabs=timeline&width=340&height=362&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false&appId"
                                width="340" height="362" style="border:none;overflow:hidden" scrolling="no"
                                frameborder="0" allowfullscreen="true"
                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                        </div>
                        <div class="col-md-4 text-center">
                            <h1 class="d-inline-block mb-10">
                                TWITTER
                            </h1>
                            <div class="twitter-timeline twitter-timeline-rendered mt-5"
                                style="display: flex; max-width: 100%; margin-top: 0px; margin-bottom: 0px;"><iframe
                                    id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true"
                                    allowfullscreen="true" class=""
                                    style="position: static; visibility: visible; width: 403px; height: 362px; display: block; flex-grow: 1;"
                                    title="Twitter Timeline"
                                    src="https://syndication.twitter.com/srv/timeline-profile/screen-name/JdihSetDPRDJTG?dnt=false&amp;embedId=twitter-widget-0&amp;features=eyJ0ZndfdGltZWxpbmVfbGlzdCI6eyJidWNrZXQiOltdLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X2ZvbGxvd2VyX2NvdW50X3N1bnNldCI6eyJidWNrZXQiOnRydWUsInZlcnNpb24iOm51bGx9LCJ0ZndfdHdlZXRfZWRpdF9iYWNrZW5kIjp7ImJ1Y2tldCI6Im9uIiwidmVyc2lvbiI6bnVsbH0sInRmd19yZWZzcmNfc2Vzc2lvbiI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9LCJ0ZndfZm9zbnJfc29mdF9pbnRlcnZlbnRpb25zX2VuYWJsZWQiOnsiYnVja2V0Ijoib24iLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X21peGVkX21lZGlhXzE1ODk3Ijp7ImJ1Y2tldCI6InRyZWF0bWVudCIsInZlcnNpb24iOm51bGx9LCJ0ZndfZXhwZXJpbWVudHNfY29va2llX2V4cGlyYXRpb24iOnsiYnVja2V0IjoxMjA5NjAwLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X3Nob3dfYmlyZHdhdGNoX3Bpdm90c19lbmFibGVkIjp7ImJ1Y2tldCI6Im9uIiwidmVyc2lvbiI6bnVsbH0sInRmd19kdXBsaWNhdGVfc2NyaWJlc190b19zZXR0aW5ncyI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9LCJ0ZndfdXNlX3Byb2ZpbGVfaW1hZ2Vfc2hhcGVfZW5hYmxlZCI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9LCJ0ZndfdmlkZW9faGxzX2R5bmFtaWNfbWFuaWZlc3RzXzE1MDgyIjp7ImJ1Y2tldCI6InRydWVfYml0cmF0ZSIsInZlcnNpb24iOm51bGx9LCJ0ZndfbGVnYWN5X3RpbWVsaW5lX3N1bnNldCI6eyJidWNrZXQiOnRydWUsInZlcnNpb24iOm51bGx9LCJ0ZndfdHdlZXRfZWRpdF9mcm9udGVuZCI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9fQ%3D%3D&amp;frame=false&amp;hideBorder=false&amp;hideFooter=false&amp;hideHeader=false&amp;hideScrollBar=false&amp;lang=id&amp;maxHeight=362px&amp;origin=https%3A%2F%2Fjdih.dprd.jatengprov.go.id%2F&amp;sessionId=0b396c3987d40334d42eaa0b03ac048015ef6497&amp;showHeader=true&amp;showReplies=false&amp;theme=dark&amp;transparent=false&amp;widgetsVersion=2615f7e52b7e0%3A1702314776716"></iframe>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <h1 class="d-inline-block mb-10">
                                TIKTOK
                            </h1>
                            <blockquote class="tiktok-embed mt-5" cite="https://www.tiktok.com/@jdih.set.dprd.pro"
                                data-unique-id="jdih.set.dprd.pro" data-embed-type="creator"
                                style="max-width: 780px; min-width: 288px;" id="v62381451535998480"> <iframe
                                    name="__tt_embed__v62381451535998480"
                                    sandbox="allow-popups allow-popups-to-escape-sandbox allow-scripts allow-top-navigation allow-same-origin"
                                    src="https://www.tiktok.com/embed/@jdih.set.dprd.pro?lang=en-US&amp;referrer=https%3A%2F%2Fjdih.dprd.jatengprov.go.id%2F"
                                    style="width: 100%; height: 362px; display: block; visibility: unset; max-height: 362px;"></iframe>
                            </blockquote>
                        </div>
                    </div>
                    <div class="row g-8 py-4">
                        <div class="text-center">
                            <h1 class="d-inline-block mb-10">
                                INSTAGRAM JDIH DPRD JATENG
                            </h1>
                            <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
                            <div class="elfsight-app-82d9a9d7-5813-4517-b62f-747e76dc069c" data-elfsight-app-lazy></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="bg-pattern1">
            <div class="container-xxl py-4 my-10">
                <div class="row">
                    <div class="col-md-9 flex-row-fluid">
                        <div class="text-left">
                            <h1 class="d-inline-block fs-2hx">
                                Youtube <span class="text-danger">JDIH DPRD JATENG</span>
                            </h1>
                            <p>Simak video-video berikut:</p>
                        </div>
                        <div class="row gy-4 mt-5">
                            <div class="col-md-6 text-center">
                                <iframe src="https://www.youtube.com/embed/7CNjLs_r19U" title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen="" class="w-100 h-lg-400px h-300px"></iframe>
                            </div>
                            <div class="col-md-6 text-center">
                                <iframe src="https://www.youtube.com/embed/WYvVWWmMIZ8" title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen="" class="w-100 h-lg-400px h-300px"></iframe>
                            </div>
                            {{-- <div class="col-md-3">
                                <div class="col-md-12 text-center">
                                    <iframe src="https://www.youtube.com/embed/oZsl0V6Vtcc" title="YouTube video player"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen="" class="w-md-100 h-md-100 h-300px"></iframe>
                                </div>
                                <div class="col-md-12 text-center">
                                    <iframe src="https://www.youtube.com/embed/yqVrHsp7f4c" title="YouTube video player"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen="" class="w-md-100 h-md-100 h-300px"></iframe>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="col-md-12 text-center">
                                    <iframe src="https://www.youtube.com/embed/mn8yZZVb-8M" title="YouTube video player"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen="" class="w-md-100 h-md-100 h-300px"></iframe>
                                </div>
                                <div class="col-md-12 text-center">
                                    <iframe src="https://www.youtube.com/embed/mNnZSNPZweY" title="YouTube video player"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen="" class="w-md-100 h-md-100 h-300px"></iframe>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-md-3 flex-row-fluid">
                        <div class="text-left">
                            <h1 class="fs-2hx">
                                Keanggotaan <span class="text-danger">JDIH</span>
                            </h1>
                            <p>Informasi Keanggotaan JDIH</p>
                        </div>
                        <div class="row">
                            <div class="tns" style="direction: ltr">
                                <div data-tns="true" data-tns-nav-position="bottom" data-tns-mouse-drag="true"
                                    data-tns-controls="false">
                                    {{-- @foreach ($all_keanggotaan as $anggota)
                                        <!--begin::Item-->
                                        <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                                            <img src="{{ asset($anggota->file) }}" class="card-rounded shadow mw-100"
                                                alt="" />
                                            <p class="mt-2 fw-bold">
                                                <span class="">{{ $anggota->jabatan }}</span>
                                                <br>
                                                <span class="text-danger">{{ $anggota->name }}</span>

                                            </p>
                                            <p class="fw-bold"></p>
                                        </div>
                                        <!--end::Item-->
                                    @endforeach --}}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="">
            <div class="container-xxl py-4 my-10">
                <div class="content flex-row-fluid">
                    <div class="text-left">
                        <h1 class="d-inline-block fs-2hx">
                            Grafik <span class="text-danger">Total Dokumen</span>
                        </h1>
                        <p>Berikut grafik total dokumen JDIH DPRD JATENG:</p>
                    </div>
                    <div class="card mt-5 p-10">
                        <div id="chartdiv" class="h-300px h-md-500px" style="width: 100%;"></div>
                        <div class="card-footer text-center">
                            <div class="fw-semibold fs-3 text-gray-500 mb-10">Beberapa grafik statistik berikut menjelaskan
                                beragam data dari dokumentasi dan
                                informasi hukum, baik data status peraturan, jumlah peraturan dan jumlah dokumen hukum yang
                                ada
                                pada website JDIH DPRD Provinsi Jawa Tengah.
                            </div>
                            <button class="btn btn-danger btn-sm">
                                Selengkapnya
                                <i class="fa fa-arrow-right-long ms-2"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="">
            <div class="container-xxl py-4 mt-10">
                <div class="content flex-row-fluid">
                    <div class="text-left">
                        <h1 class="d-inline-block fs-2hx">
                            Survey <span class="text-warning">Kepuasan</span>
                        </h1>
                        <p>Yuk beri penilaian! untuk meningkatkan pelayanan kami.</p>
                    </div>
                    <div class="row g-8 mt-5">
                        {{-- @if ($already_survey)
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="text-center">Pengalaman anda pada website ini:</h2>
                                        <h2 class="fs-4tx text-center">
                                            <i class="ki-solid ki-star text-warning fs-4tx"></i>
                                            {!! $already_survey->nilai !!}
                                        </h2>
                                        <div class="fw-semibold fs-4 text-gray-500 mb-10">Terima kasih atas penilaian yang
                                            telah
                                            anda berikan, masukan anda sangat
                                            bermanfaat untuk kemajuan unit kami agar terus memperbaiki dan meningkatkan
                                            kualitas
                                            pelayanan bagi masyarakat.
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @else
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="card d-flex flex-column w-100">
                                        <form id="ikm_form"
                                            class="card-body d-flex flex-column gap-1 align-items-center">
                                            @csrf
                                            <input type="hidden" name="ip" value="{{ $_SERVER['REMOTE_ADDR'] }}">
                                            <h2>Bagikan pengalaman anda pada website ini:</h2>
                                            <div class="rate">
                                                <input type="radio" id="star5" name="rate" value="5"
                                                    required />
                                                <label class="fs-4hx" for="star5" title="5"></label>
                                                <input type="radio" id="star4" name="rate" value="4" />
                                                <label class="fs-4hx" for="star4" title="4"></label>
                                                <input type="radio" id="star3" name="rate" value="3" />
                                                <label class="fs-4hx" for="star3" title="3"></label>
                                                <input type="radio" id="star2" name="rate" value="2" />
                                                <label class="fs-4hx" for="star2" title="2"></label>
                                                <input type="radio" id="star1" name="rate" value="1" />
                                                <label class="fs-4hx" for="star1" title="1"></label>
                                            </div>
                                            <textarea class="form-control" name="saran" cols="30" rows="3"
                                                placeholder="Berikan saran membangun(opsional)"></textarea>
                                            <button type="button" id="ikm_submit_btn" class="btn btn-dark w-100">Kirim
                                                Survey</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif --}}
                        <div class="col-md-4 card">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <div class="">
                                    <h2 class="fs-3tx text-center">
                                        <i class="ki-solid ki-star text-warning fs-3tx"></i>
                                        4,7
                                    </h2>
                                    <h2 class="text-center text-muted">
                                        <i class="ki-solid ki-user"></i>
                                        154
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-8 mt-5">
                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card d-flex flex-column w-100">
                                <div class="card-body">
                                    <div id="survey-chart" style="width: 100%;height:300px">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="bg-grid-fade">
            <div class="container-xxl pt-4 mt-10">
                <div class="content flex-row-fluid">
                    <div class="row mt-10">
                        <div class="col-md-6 d-flex flex-column justify-content-center gap-2 mb-5">
                            <h1 class="fs-2hx" style="color: #14532D">
                                Link Terkait
                            </h1>
                            <div class="d-flex gap-2 flex-wrap">
                                {{-- <img src="{{ asset('img/jdihn.jpg') }}" alt="JDIHN Logo" class="h-50px"> --}}
                                <img src="{{ asset('img/emonev.png') }}" alt="JDIHN Logo" class="h-75px">
                                <img src="{{ asset('img/lapor-gub.png') }}" alt="JDIHN Logo" class="h-75px">
                                <img src="{{ asset('img/Perjinan-Jateng.png') }}" alt="JDIHN Logo" class="h-75px">
                                <img src="{{ asset('img/cyber-UMKM.png') }}" alt="JDIHN Logo" class="h-75px">
                                <img src="{{ asset('img/SiHatia.png') }}" alt="JDIHN Logo" class="h-75px">
                            </div>
                            <div>
                                <img src="{{ asset('img/jdihn.jpg') }}" alt="JDIHN Logo" class="h-100px">
                            </div>
                            <div>
                                <img src="{{ asset('img/e-pengumuman.jpeg') }}" alt="JDIHN Logo" class="w-100">
                            </div>
                            <h1 class="fs-2hx" style="color: #14532D">
                                Download E-JDIH DPRD
                            </h1>
                            <h4 class="" style="color: #14532D">
                                Gunakan aplikasi e-JDIH DPRD Jateng untuk mempermudah mendapatkan informasi produk hukum
                                terkini.
                            </h4>
                            <a href="https://play.google.com/store/apps/details?id=com.jdihdprd.myapp" target="_blank">
                                <img src="{{ asset('img/google-play-download.png') }}" alt="Google Play Logo"
                                    class="h-50px">
                            </a>
                        </div>
                        <div class="col-md-6">
                            <img src="{{ asset('img/abstract1.png') }}" alt=""
                                class="h-100 w-100 d-none d-md-block">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection


    @section('script')
        <!-- AM5 Resources -->
        <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
        <!-- AM5 Resources -->

        <!--Variables-->
        <script>
            const produkHukumUrl = "{{ '#' }}";
            const docCountCategories = 76;
            const categoryIds = [];
            const ratings = 5;
        </script>
        <!--Variables-->

        <!-- Chart code -->
        <script>
            am5.ready(function() {
                // Create root element
                var root = am5.Root.new("chartdiv");

                // Set themes
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);

                // Create chart
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    pinchZoomX: true,
                    paddingLeft: 0,
                    paddingRight: 1
                }));

                // Add cursor
                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                cursor.lineX.set("visible", false);

                // Create axes
                var yRenderer = am5xy.AxisRendererY.new(root, {
                    minGridDistance: 30,
                    minorGridEnabled: true
                });

                yRenderer.labels.template.setAll({
                    centerX: am5.p50,
                    centerY: am5.p100,
                    paddingRight: 15,
                    fontWeight: "bold",
                    cursorOverStyle: "pointer",
                    textDecoration: "underline"
                });

                // Setup background for interactivity
                yRenderer.labels.template.setup = function(target) {
                    target.set("background", am5.Rectangle.new(root, {
                        fill: am5.color(0xff0000),
                        fillOpacity: 0
                    }));
                };

                // Add event listener for hover
                yRenderer.labels.template.events.on("pointerover", function(ev) {
                    ev.target.set("fill", am5.color(0xdc3545)); // Bootstrap's bg-success color
                });

                // Add event listener for hover out
                yRenderer.labels.template.events.on("pointerout", function(ev) {
                    ev.target.set("fill", am5.color(0x000)); // Reset to Bootstrap primary color
                });
                // Add click event listener to labels
                yRenderer.labels.template.events.on("click", function(ev) {
                    var dataItem = ev.target.dataItem;
                    if (dataItem) {
                        var category = dataItem.get("category");
                        var categoryId = categoryIds[category][0].singkatan;
                        var url = produkHukumUrl + `?tipe_dokumen=${categoryId}`;
                        window.location.href = url;
                    }
                });

                yRenderer.grid.template.setAll({
                    location: 1
                });

                var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
                    maxDeviation: 0.3,
                    categoryField: "category",
                    renderer: yRenderer,
                    tooltip: am5.Tooltip.new(root, {})
                }));

                var xRenderer = am5xy.AxisRendererX.new(root, {
                    strokeOpacity: 0.1
                });

                var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.3,
                    renderer: xRenderer
                }));

                // Create series
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: "Grafik Total Dokumen",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueXField: "value",
                    sequencedInterpolation: true,
                    categoryYField: "category",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueX}"
                    })
                }));

                series.columns.template.setAll({
                    width: am5.percent(50), // Adjust the width as needed to make columns thinner
                    cornerRadiusTL: 5,
                    cornerRadiusTR: 5,
                    strokeOpacity: 0,
                    fill: am5.color(0xdc3545) // Bootstrap's bg-success color
                });

                // Set data
                var data = docCountCategories;
                yAxis.data.setAll(data);
                series.data.setAll(data);

                // Make stuff animate on load
                series.appear(1000);
                chart.appear(1000, 100);
            }); // end am5.ready()
        </script>

        <!-- Chart code -->
        <!-- Chart code -->
        <script>
            am5.ready(function() {
                // Create root element
                var root = am5.Root.new("survey-chart");

                // Set themes
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);

                // Create chart
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    pinchZoomX: true,
                    paddingLeft: 0,
                    paddingRight: 1
                }));

                // Add cursor
                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                cursor.lineX.set("visible", false);

                // Create axes
                var yRenderer = am5xy.AxisRendererY.new(root, {
                    minGridDistance: 30,
                    minorGridEnabled: true
                });

                yRenderer.labels.template.setAll({
                    centerX: am5.p50,
                    centerY: am5.p100,
                    paddingRight: 15,
                    fontWeight: "bold",
                });

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.3,
                    renderer: yRenderer
                }));

                // Customize y-axis labels to use icons
                yAxis.get("renderer").labels.template.adapters.add("html", function(html, target) {
                    return "<i class='fa fa-star text-warning'></i>{key}";
                });

                // Setup background for interactivity
                yRenderer.labels.template.setup = function(target) {
                    target.set("background", am5.Rectangle.new(root, {
                        fill: am5.color(0xff0000),
                        fillOpacity: 0
                    }));
                };

                yRenderer.grid.template.setAll({
                    location: 1
                });

                var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
                    maxDeviation: 0.3,
                    categoryField: "key",
                    renderer: yRenderer,
                    tooltip: am5.Tooltip.new(root, {})
                }));

                var xRenderer = am5xy.AxisRendererX.new(root, {
                    strokeOpacity: 0.1
                });

                var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.3,
                    renderer: xRenderer
                }));

                // Create series
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: "Grafik Total Dokumen",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueXField: "value",
                    sequencedInterpolation: true,
                    categoryYField: "key",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueX}"
                    })
                }));

                series.columns.template.setAll({
                    width: am5.percent(10), // Adjust the width as needed to make columns thinner
                    cornerRadiusTL: 5,
                    cornerRadiusTR: 5,
                    strokeOpacity: 0,
                    fill: am5.color(0xF6C000) // Bootstrap's bg-success color
                });

                // Set data
                var data = ratings;
                yAxis.data.setAll(data);
                series.data.setAll(data);

                // Make stuff animate on load
                series.appear(1000);
                chart.appear(1000, 100);
            }); // end am5.ready()
        </script>
        <!-- Chart code -->

        <!-- begin: Helper Functions -->
        <!-- This section contains helper functions for the page -->
        <script>

            function submitIKM() {
                var form = $('#ikm_form');
                var formData = new FormData(form[0]);
                // Add the CSRF token to the form data
                formData.append('_token', $('input[name="_token"]').val());
                $.ajax({
                    url: "{{ '#' }}",
                    method: 'post',
                    data: formData,
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Mengirim...'
                        })
                        Swal.showLoading();
                    },
                    success: function(response) {
                        Swal.fire({
                            text: "Survey Berhasil Dikirim!",
                            icon: "success",
                        })
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: xhr.responseJSON.message,
                            icon: 'warning'
                        });

                    },
                    complete: function() {
                        Swal.hideLoading();
                    }
                })
            }

            /**
             * Initialize the Google Translate widget.
             * This function creates a new instance of the Google Translate widget and sets the page language to 'id' (Indonesian).
             */
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'id'
                }, 'google_translate_element');
            }

            /**
             * Change the language of the Google Translate widget by clicking a button.
             * This function takes a language code as a parameter and sets the selected language of the Google Translate widget.
             * It finds the corresponding language option in the widget's select field and sets its selected index to the current index.
             * Afterwards, it triggers a 'change' event on the select field to update the widget's language.
             * @param {string} val - The language code to set the widget to.
             */
            function changeLanguageByButtonClick(val) {
                var language = val;
                var selectField = document.querySelector("#google_translate_element select");
                for (var i = 0; i < selectField.children.length; i++) {
                    var option = selectField.children[i];
                    // find desired language and change the former language of the hidden selection-field
                    if (option.value == language) {
                        selectField.selectedIndex = i;
                        // trigger change event afterwards to make google-lib translate this side
                        selectField.dispatchEvent(new Event('change'));
                        break;
                    }
                }
            }

            function initNews() {
                $.ajax({
                    url: "{{ '#' }}",
                    data: {
                        limit: 4,
                    },
                    type: 'GET',
                    success: function(data) {
                        $('#news_container').html(data);
                    }
                })
            }
        </script>
        <!-- end: Helper Functions -->

        <script>
            $(document).ready(function() {
                initNews();
                if ($('a[href="#kt_tab_pane_7"]').hasClass('active')) {
                    $('#buttonTerbaru').show();
                } else if ($('a[href="#kt_tab_pane_8"]').hasClass('active')) {
                    $('#buttonTerpopuler').show();
                }

                // Event listener for tab change
                $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                    var target = $(e.target).attr("href"); // activated tab

                    // Hide both buttons
                    $('#buttonTerbaru').hide();
                    $('#buttonTerpopuler').hide();

                    // Show the button corresponding to the active tab
                    if (target === '#kt_tab_pane_7') {
                        $('#buttonTerbaru').show();
                    } else if (target === '#kt_tab_pane_8') {
                        $('#buttonTerpopuler').show();
                    }
                });
                $('#ikm_submit_btn').on('click', function(event) {
                    event
                        .preventDefault(); // Prevent the default form submission if the button is within a form
                    console.log('CLICK');
                    var form = $('#ikm_form');
                    var formData = new FormData(form[0]);
                    // Add the CSRF token to the form data
                    formData.append('_token', $('input[name="_token"]').val());

                    $.ajax({
                        url: "{{ '#' }}",
                        method: 'post',
                        data: formData,
                        contentType: false, // Important for sending FormData
                        processData: false, // Important for sending FormData
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Mengirim...',
                            })
                            Swal.showLoading();
                        },
                        success: function(response) {
                            Swal.fire({
                                text: "Survey Berhasil Dikirim!",
                                icon: "success",
                            })
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: xhr.responseJSON.message,
                                icon: 'warning'
                            });
                        },
                        complete: function() {
                            Swal.hideLoading();
                            crip
                        }
                    });
                });
            });
        </script>
    @endsection
