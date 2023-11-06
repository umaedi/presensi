<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? "Dashboard" }}</title>

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
    <link rel="stylesheet" href="{{ asset('assets/pegawai') }}/js/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{ asset('assets/pegawai') }}/css/fakeLoader.min.css">
    <!-- PWA  -->
    <link rel="apple-touch-icon" href="{{ asset('assets/icon/lc_icon_absent.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    @vite([])
</head>

<body>
<div class="fakeLoader"></div>
<div class="x-container">
    @yield('content')
    @include('layouts.pegawai.navbar')
    @include('layouts.pegawai.button-action')
    @include('layouts.pegawai.footer')
</div>


<script src="{{ asset('assets/pegawai') }}/js/lib/jquery-3.4.1.min.js"></script>
<!-- Bootstrap-->
<script src="{{ asset('assets/pegawai') }}/js/lib/popper.min.js"></script>
<!-- Ionicons -->
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
<script src="https://kit.fontawesome.com/0ccb04165b.js" crossorigin="anonymous"></script>
<!-- Base Js File -->
<script src="{{ asset('assets/pegawai') }}/js/sweetalert.min.js"></script>
<script src="{{ asset('assets/pegawai') }}/js/webcamjs/webcam.min.js"></script>
<script src="{{ asset('assets/pegawai') }}/js/fakeLoader.min.js"></script>
{{-- <script src="{{ asset('assets/pegawai') }}/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script> --}}
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPd9X55ZmEgE6R-T2mBiQVRGK1hjVNou8&libraries=places"></script>
{{-- <script src="{{ asset('assets/stap') }}/js/sw-script.js"></script> --}}
<script type="text/javascript">
$(document).ready(function loading() {
    $.fakeLoader({
        timeToHide:500,
        spinner:"spinner7"
    });
    sw();
});

function sw() {
    if (!navigator.serviceWorker.controller) {
    navigator.serviceWorker.register("/sw.js").then(function (reg) {
        console.log("Service worker has been registered for scope: " + reg.scope);
    });
    }
}

async function transAjax(data) {
    html = null;
    data.headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    await $.ajax(data).done(function(res) {
        html = res;
    })
        .fail(function() {
            return false;
        })
    return html
}
</script>
@stack('js')
</body>

</html>