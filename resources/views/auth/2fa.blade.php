<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: MetronicProduct Version: 8.2.7
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../../../" />
    <title>{{$global_option->name}}</title>
    <meta charset="utf-8" />
    <meta name="description"
        content="{{$global_option->description}}" />
    <meta name="keywords"
        content="{{$global_option->keywords}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="{{$global_option->name}}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{$global_option->name}}" />
    <link rel="canonical" href="http://preview.keenthemes.comauthentication/layouts/corporate/sign-in.html" />
    <link rel="shortcut icon" href="{{ $global_option->favicon ? $global_option->favicon : asset('media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="auth-bg">
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
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px p-10">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="login_form"
                            action="{{ route('login.auth') }}" method="POST">
                            @csrf <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-gray-900 fw-bolder mb-3">Two Factor Authentication</h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">Silahkan masukkan kode OTP yang telah kami kirim ke email anda
                                </div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Separator-->
                            <div class="separator separator-content my-14">
                                <span class="w-125px text-gray-500 fw-semibold fs-7"></span>
                            </div>
                            <!--end::Separator-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::username-->
                                <input type="text" placeholder="Kode OTP" name="twofa_code" autocomplete="off"
                                    class="form-control bg-transparent" />
                                <!--end::username-->
                            </div>
                            <div class="g-recaptcha mb-4" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"
                                data-action="LOGIN"></div>
                            <!--begin::Wrapper-->
                            <!--end::Wrapper-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="login_submit" class="btn btn-primary"data-action='submit'>
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Sign In</span>
                                    <!--end::Indicator label-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                            <!--begin::Sign up-->
                            <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
                                <a href="{{route('register')}}" class="link-primary">Sign up</a>
                            </div>
                            <!--end::Sign up-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Form-->
                <!--begin::Footer-->
                <div class="w-lg-500px d-flex flex-stack px-10 mx-auto justify-content-end">
                    <!--begin::Links-->
                    <div class="d-flex fw-semibold text-primary fs-base gap-5">
                        <a href="https://keenthemes.com" target="_blank">Terms</a>
                        <a href="https://keenthemes.com" target="_blank">Plans</a>
                        <a href="https://keenthemes.com" target="_blank">Contact Us</a>
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Body-->
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
                style="background-image: url({{ asset('media/misc/auth-bg.png') }})">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <!--begin::Logo-->
                    <a href="../../demo1/dist/index.html" class="mb-0 mb-lg-12">
                        <img alt="Logo" src="{{ asset('media/logos/custom-1.svg') }}" class="h-60px h-lg-75px" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Image-->
                    <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20"
                        src="{{ asset('media/misc/auth-screens.png') }}" alt="" />
                    <!--end::Image-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Aside-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    <!--end::Javascript-->
    <script>
        $(document).ready(function() {

            $('#login_submit').on('click', function(event) {
                event.preventDefault();

                // Show the SweetAlert loading modal
                Swal.fire({
                    title: 'Logging in',
                    text: 'Silahkan tunggu...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                Swal.showLoading();

                var formData = $('#login_form').serialize();

                $.ajax({
                    url: '{{ route('2fa.verify.submit') }}', // URL to your login route
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        Swal.close();

                        if (response.status) {
                            // If login is successful
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.pesan,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                document.location = '/dashboard';
                            });
                        } else {
                            // If login fails
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Login!',
                                text: response.pesan
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors that occur during the AJAX request
                        let errors = xhr.responseJSON.errors;

                        // Get the first error message
                        let firstErrorMessage = '';
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                firstErrorMessage = errors[key][
                                0]; // Get the first message for the first error
                                break; // Exit after the first error
                            }
                        }

                        // Show the first error message in SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal login!',
                            text: firstErrorMessage,
                            showConfirmButton: true,
                        });
                    }
                });

            });
        });
    </script>

</body>
<!--end::Body-->

</html>
