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

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />