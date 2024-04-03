@extends('layouts.pages')
@section('content')
    <div id="appCapsule">
        <div>
            <iframe id="googleForm" src="https://docs.google.com/forms/d/e/1FAIpQLSdKodnZwD4Nr5vlICNu2UBCyS0dbvMo37AEMJD3EIvHG4aEtQ/viewform?embedded=true" width="100%" height="11941" frameborder="0" marginheight="0" marginwidth="0">Memuat…</iframe>
        </div>
    </div>
    <script>
        const iframe = document.getElementById('googleForm');
        iframe.onload = function() {
          const iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
          const submitButton = iframeDocument.querySelector('.freebirdFormviewerViewNavigationSubmitButton');
          submitButton.addEventListener('click', function() {
            window.location.href = '/user/dashboard';
          });
        };
      </script>
@endsection
