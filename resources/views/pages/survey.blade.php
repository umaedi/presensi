@extends('layouts.pages')
@section('content')
    <div id="appCapsule">
        <div>
            <iframe id="myIframe" src="https://docs.google.com/forms/d/e/1FAIpQLSdKodnZwD4Nr5vlICNu2UBCyS0dbvMo37AEMJD3EIvHG4aEtQ/viewform?embedded=true" width="100%" height="11941" frameborder="0" marginheight="0" marginwidth="0">Memuat…</iframe>
        </div>
    </div>
    <script>
         let btn = document.querySelector('.l4V7wb');
         btn.addEventListener('click', function() {
            // Mengarahkan pengguna ke '/user/dashboard' saat tombol diklik
            window.location.href = '/user/dashboard';
        });
    </script>
@endsection
