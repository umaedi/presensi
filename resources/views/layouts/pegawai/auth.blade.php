<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ $title ?? 'Login' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="theme-color" content="#6777ef"/>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets') }}/pegawai/css/style.css">
  <!-- PWA  -->
  <meta name="theme-color" content="#6777ef">
  <link rel="apple-touch-icon" href="{{ asset('assets/icon/lc_icon_absent.png') }}">
  <link rel="manifest" href="{{ asset('/manifest.json') }}">

</head>

<body>
  <div id="app">
    @yield('content')
  </div>
</body>

<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>
@stack('js')
</html>