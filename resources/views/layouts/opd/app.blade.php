<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="theme-color" content="#0a5414"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? "Dashboard" }}</title>
  <link rel="stylesheet" href="{{ asset('assets/admin/css') }}/bootstrap.4.3.1.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css') }}/style.css">
  <link rel="stylesheet" href="{{ asset('assets/admin/css') }}/components.css">
  <link rel="stylesheet" href="{{ asset('assets/admin/css') }}/fakeLoader.min.css">

  {{-- <link rel="stylesheet" href="{{ asset('assets/stap') }}/css/style.css"> --}}
  {{-- <link rel="stylesheet" href="{{ asset('assets/stap') }}/css/sw-custom.css"> --}}

  <!-- PWA  -->
  {{-- <link rel="apple-touch-icon" href="{{ asset('/img/icon/lc_icon_xbaznas.png') }}">
  <link rel="manifest" href="{{ asset('/manifest.json') }}"> --}}
  @stack('css')
  @vite([])
</head>
<body>
  {{-- <div class="fakeloader"></div> --}}
  <div id="app">
    <div class="main-wrapper container">
      @include('layouts.opd.navbar')
      @yield('content')
      @include('layouts.opd.footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset('assets/admin/js') }}/stisla.js"></script>

  <script src="{{ asset('assets/admin/js') }}/scripts.js"></script>
  <script src="{{ asset('assets/admin/js') }}/custom.js"></script>

  <script src="{{ asset('assets/admin/js') }}/fakeLoader.min.js"></script>
  {{-- <script>
    $(document).ready(function(){
        $.fakeLoader({
            timeToHide:500,
            spinner:"spinner7"
        });
    });
  </script> --}}

{{-- <script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script> --}}

<script type="text/javascript">
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
