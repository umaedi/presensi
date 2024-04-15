@extends('layouts.pages')
@section('content')
    <div id="appCapsule">
        <div>
            <a href="/user/dashboard" id="kembali" class="btn btn-primary btn-block d-none">KEMBALI</a>
            <iframe id="googleForm" src="https://docs.google.com/forms/d/e/1FAIpQLSdKodnZwD4Nr5vlICNu2UBCyS0dbvMo37AEMJD3EIvHG4aEtQ/viewform?embedded=true" width="100%" height="11941" frameborder="0" marginheight="0" marginwidth="0">Memuat…</iframe>
        </div>
    </div>
    <script>
        const iframe = document.getElementById('googleForm');
        const kembali = document.getElementById('kembali');
        iframe.onload = function() {
            const iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
            const submitButton = iframeDocument.querySelector('.freebirdFormviewerViewNavigationSubmitButton');
            submitButton.addEventListener('click', function() {
                iframe.classList.add('d-none');
                kembali.classList.remove('d-none');
            });
        };
    </script>
    
@endsection
