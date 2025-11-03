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
    <base href="../../" />
    <title>{{ $company_data->name . ' | ' . $company_data->description}}</title>
    <meta charset="utf-8" />
    <meta name="description"
        content="{{$global_option->description}}" />
    <meta name="keywords"~
        content="{{$global_option->keywords}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="{{ $company_data->name . ' | ' . $company_data->description}}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{$global_option->name}}" />
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
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
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Body-->
            <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true"
                data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav"
                data-kt-scroll-offset="5px" data-kt-scroll-save-state="true"
                style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
                <!--begin::Email template-->
                <style>
                    html,
                    body {
                        padding: 0;
                        margin: 0;
                        font-family: Inter, Helvetica, "sans-serif";
                    }

                    a:hover {
                        color: #009ef7;
                    }
                </style>
                <div id="#kt_app_body_content"
                    style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
                    <div
                        style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                            height="auto" style="border-collapse:collapse">
                            <tbody>
                                <tr>
                                    <td align="center" valign="center"
                                        style="text-align:center; padding-bottom: 10px">
                                        <!--begin:Email content-->
                                        <div style="text-align:center; margin:0 15px 34px 15px">
                                            <!--begin:Logo-->
                                            <div style="margin-bottom: 10px">
                                                @livewire('email', ['component'=> 'logo'])
                                            </div>
                                            <!--end:Logo-->
                                            <!--begin:Media-->
                                            <div style="margin-bottom: 15px">
                                                @livewire('email', ['component'=> 'thumb'])
                                            </div>
                                            <!--end:Media-->
                                            <!--begin:Text-->
                                            <div
                                                style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                                <p
                                                    style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">
                                                    Hey {{$user->name}}, berikut kode verifikasi dua langkah anda!</p>
                                                <p
                                                    style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">
                                                    {{ $user->twofa_code }}</p>
                                                <p
                                                    style="margin-bottom:9px; color:#181C32; font-size: 16px; font-weight:400">
                                                    Atau bisa klik tombol dibawah ini.</p>
                                            </div>
                                            <!--end:Text-->
                                            <!--begin:Action-->
                                            <a href="{{ $verificationUrl }}"
                                                style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">Verifikasi 2FA</a>
                                            <!--begin:Action-->
                                        </div>
                                        <!--end:Email content-->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="center"
                                        style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                                        <p style="margin-bottom:2px">Hubungi nomor perusahaan kami: {{ $company_data->phone }}
                                        </p>
                                        <p style="margin-bottom:4px">Anda bisa menghubungi kami juga melalui
                                            <a href="mailto:{{ $company_data->email }}" rel="noopener" target="_blank"
                                                style="font-weight: 600">{{ $company_data->email }}</a>.
                                        </p>
                                        <p>Jam kerja kami mulai {{ \Carbon\Carbon::parse($company_data->starthour)->format('H:i') . ' - ' . \Carbon\Carbon::parse($company_data->endhour)->format('H:i') }}, di hari Senin sampai Jumat</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="center"
                                        style="text-align:center; padding-bottom: 20px;">
                                        <style>
                                            a > i {
                                                font-size: 24px;
                                            }
                                        </style>
                                        @foreach ($social_media as $item)
                                        <a href="{{ $item->link }}" style="margin-right:10px">
                                            {!! $item->icon !!}
                                        </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="center"
                                        style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                        <p>&copy; Copyright {{ $company_data->name }}.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Email template-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{asset('plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('js/scripts.bundle.js')}}"></script>
    <!--end::Global Javascript Bundle-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
