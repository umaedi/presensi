@extends('layouts.pegawai.app')
@section('content')
        <div id="appCapsule">
            <div class="section my-3">
                <div class="section mt-2 text-center">
                    <div class="card">
                        <div class="card-body pt-3 pb-3">
                            <img src="{{ asset('assets/img') }}/vector1.png" alt="image" class="imaged w-50 ">
                            <h2 class="mt-2">Dinas Luar</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @include('layouts.modal._modal_dl')
@endsection
@push('js')
    <script type="text/javascript">
    $('#formDl').submit(async function(e) {
        e.preventDefault();
        $('#x-action').addClass('d-none');
    
        var data = new FormData(this);
        data.append('img', image);
        data.append('latLong', latLong);
        var param = {
            method: 'POST',
            url: '/user/presensi_dl/store',
            data: data,
            processData:false,
            contentType: false,
            cache: false,
        }

        loadingsubmit(true);
        await transAjax(param).then((res) => {
            loadingsubmit(false);
            swal({ text: res.message, icon: 'success', timer: 3000, }).then(() => {
                window.location.href = '/user/dashboard';
            });
        }).catch((err) => {
            loadingsubmit(false);
            swal({ text: err.responseJSON.message, icon: 'error', timer: 3000, }).then(() => {
                window.location.href = '/user/dashboard';
            });
        });

        function loadingsubmit(state) {
        if (state) {
            $('#loadingSubmit').removeClass('d-none');
        } else {
            $('#loadingSubmit').addClass('d-none');
            $('#x-action').removeClass('d-none');
        }
    }
    });
    </script>
@endpush