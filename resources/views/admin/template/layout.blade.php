<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    {{-- PENTING: Pastikan file metadata ini HANYA berisi CSS dan Meta Tags. JANGAN ada Script JS di sini. --}}
    @include('admin.template.metadata')
    @yield('css')
</head>
<!--end::Head-->

<!--begin::Body-->
<body id="kt_body" class="aside-enabled">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup-->

    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row">
            
            @include('admin.template.sidebar')
            
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid pt-0" id="kt_wrapper">
                
                @include('admin.template.header')
                
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid mt-12" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-xxl mt-12">
                            @yield('content')
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Content-->
                
                @include('admin.template.footer')
                
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Scrolltop-->

    <!-- ========================================================= -->
    <!-- JAVASCRIPT SECTION (WAJIB DI BAWAH SINI) -->
    <!-- ========================================================= -->

    <!-- 1. Global Javascript Bundle (Jantung Metronic) -->
    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    <!-- 2. Global Helper Functions (Rupiah & Debounce) -->
    <script>
        // Script Format Rupiah
        document.addEventListener('DOMContentLoaded', function() {
            const rupiahInputs = document.querySelectorAll('.rupiah-input');
            rupiahInputs.forEach(input => {
                input.addEventListener('keyup', function(e) {
                    this.value = formatRupiah(this.value);
                });
                if(input.value) {
                    input.value = formatRupiah(input.value);
                }
            });
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        // Helper Functions Lainnya
        function debounce(func, delay) {
            let timeoutId;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function() {
                    func.apply(context, args);
                }, delay);
            };
        }

        function initSelect2(route, selectElement, params = null) {
            var id = null
            if (params != null) { id = params }
            $(selectElement).select2({
                ajax: {
                    url: route,
                    dataType: 'json',
                    data: function(params) {
                        return { q: params.term, id: id };
                    },
                    processResults: function(data) {
                        return { results: data.results };
                    },
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    allowClear: true
                }
            });
        }
    </script>

    <!-- 3. Page Specific Scripts (Yield & Stack) -->
    <!-- Ini harus paling akhir biar jQuery dari plugins.bundle.js sudah siap -->
    @yield('script')
    @stack('scripts')

</body>
<!--end::Body-->
</html>
{{-- ```

---

### ⚠️ LANGKAH WAJIB BERIKUTNYA (JANGAN DILEWATKAN)

Agar tidak error lagi (`sortable is not a function`), kamu **HARUS MEMASTIKAN** file `admin/template/metadata.blade.php` **BERSIH** dari tag `<script>`.

Buka file **`resources/views/admin/template/metadata.blade.php`**.

**Pastikan isinya HANYA seperti ini (CSS Saja):**

```html --}}
<title>{{$global_option->name}}</title>
<meta charset="utf-8" />
<meta name="description" content="{{$global_option->description}}" />
<meta name="keywords" content="{{$global_option->keywords}}" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{$global_option->name}}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{$global_option->name}}" />
<link rel="canonical" href="http://preview.keenthemes.comindex.html" />
<link rel="shortcut icon" href="{{ $global_option->favicon ? $global_option->favicon : asset('media/logos/favicon.ico') }}" />

<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- Stylesheets (CSS Only) -->
<link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

// <!-- ❌ JANGAN ADA SCRIPT JS DI SINI! HAPUS JIKA ADA! ❌ -->