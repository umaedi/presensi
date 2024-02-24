<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="JNUql3k5Q0B10HhKDHMUZRMQb9Z23lLwY3oLqiCAJH0" />
    <title>{{ $title ?? 'Dashboard' }}</title>

    <meta name="theme-color" content="#6777ef">
    <meta name="msapplication-navbutton-color" content="#6777ef">
    <meta name="apple-mobile-web-app-status-bar-style" content="#6777ef">
    <meta name="description" content="DISKOMINFO TUBA">
    <meta name="keywords" content="DISKOMINFO TUBA">
    <meta name="author" content="DISKOMINFO TUBA">
    <meta http-equiv="Copyright" content="DISKOMINFO TUBA">
    <meta name="copyright" content="DISKOMINFO TUBA">

    <link rel="stylesheet" href="{{ asset('assets/pegawai') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('assets/pegawai') }}/css/sw-custom.css">
    <link rel="stylesheet" href="{{ asset('css') }}/placeholder-loading.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- PWA  -->
    <link rel="apple-touch-icon" href="{{ asset('assets/icon/lc_icon_presensi.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    {{-- @livewireStyles --}}

</head>

<body>
    <div class="x-container">
        @yield('content')
        @include('layouts.pegawai.navbar')
        @include('layouts.pegawai.footer')
    </div>
</body>

</html>
