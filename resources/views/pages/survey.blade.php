@extends('layouts.pages')
@section('content')
    <div id="appCapsule">
        <div>
            <iframe id="myIframe" src="https://docs.google.com/forms/d/e/1FAIpQLSdKodnZwD4Nr5vlICNu2UBCyS0dbvMo37AEMJD3EIvHG4aEtQ/viewform?embedded=true" width="100%" height="11941" frameborder="0" marginheight="0" marginwidth="0">Memuat…</iframe>
        </div>
    </div>
    <script>
        var iframe = document.getElementById('myIframe');
        var urlSpan = document.getElementById('url_iframe');
    
        // Menambahkan event listener untuk event 'load'
        iframe.addEventListener('load', function() {
            // Mendapatkan URL saat ini dari <iframe>
            var currentURL = iframe.contentWindow.location.href;
    
            // Mengecek apakah URL mengandung teks "formResponse?embedded=true"
            if (currentURL.includes("formResponse")) {
                window.location.href = '/user/dashboard';
            } else {
                // Menampilkan URL saat ini di dalam elemen <span>
                urlSpan.textContent = currentURL;
            }
        });
    </script>
@endsection
