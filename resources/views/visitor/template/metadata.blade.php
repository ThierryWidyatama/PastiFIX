<title>{{ $global_option->name }}</title>
<meta charset="utf-8" />
<meta name="description"
    content="{{$global_option->description}}" />
<meta name="keywords"
    content="{{$global_option->keywords}}" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $global_option->name }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ $global_option->name }}" />
<link rel="canonical" href="http://preview.keenthemes.comlanding.html" />
<link rel="shortcut icon" href="{{ asset($global_option->favicon) }}" />
<!--begin::Fonts(mandatory for all pages)-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
<link href="{{ asset('plugins/global/plugins_visitor.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/style_visitor.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('plugins/global/plugins_visitor.bundle.js') }}"></script>
<script src="{{ asset('js/scripts.bundle.js') }}"></script>
<!--end::Global Stylesheets Bundle-->
<script>
    // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
</script>