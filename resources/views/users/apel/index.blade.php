@extends('layouts.pegawai.app')
@section('content')
        <div id="appCapsule">
            <div class="section my-3">
                <div class="section mt-2">
                    <div class="card">
                        <div class="card-body pt-3 pb-3 text-center">
                            <img src="{{ asset('assets/img') }}/vector1.png" alt="image" class="imaged w-50 ">
                            <h2 class="text-center">Silakan pilih titik lokasi kumpul dibawah ini</h2>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <a href="javacsript:void(0)" onclick="openCamera('4', '-4.4950449', '105.2206886')">
                        <div class="card-body">
                            <p>1. Lapangan pemda</p>
                        </div>
                        </a>
                    </div>
                    <div class="card mt-2">
                        <a href="javacsript:void(0)" onclick="openCamera('3', 'lat', 'long')">
                        <div class="card-body">
                            <p>2. Lapangan sport center</p>
                        </div>
                        </a>
                    </div>
                    <div class="card mt-2">
                        <a href="javacsript:void(0)" onclick="openCamera('3', 'lat', 'long')">
                        <div class="card-body">
                            <p>3. Islamic center</p>
                        </div>
                        </a>
                    </div>
                    <div class="card mt-2">
                        <a href="javacsript:void(0)" onclick="openCamera('3', 'lat', 'long')">
                        <div class="card-body">
                            <p>4. Terminal</p>
                        </div>
                        </a>
                    </div>
                    <div class="card mt-2">
                        <a href="javacsript:void(0)" onclick="openCamera('3', 'lat', 'long')">
                        <div class="card-body">
                            <p>5. Cakat Nyeyek</p>
                        </div>
                        </a>
                    </div>
                    <div class="card mt-2">
                        <a href="javacsript:void(0)" onclick="openCamera('3', 'lat', 'long')">
                        <div class="card-body">
                            <p>6. Pasar Putri Agung</p>
                        </div>
                        </a>
                    </div>
                    <div class="card mt-2">
                        <a href="javacsript:void(0)" onclick="openCamera('3', 'lat', 'long')">
                        <div class="card-body">
                            <p>7. Gedung Dekranasda</p>
                        </div>
                        </a>
                    </div>
                    <div class="card mt-2">
                        <a href="javacsript:void(0)" onclick="openCamera('3', 'lat', 'long')">
                        <div class="card-body">
                            <p>8. Gedung Kartini</p>
                        </div>
                        </a>
                    </div>
                    <div class="card mt-2">
                        <a href="javacsript:void(0)" onclick="openCamera('3', 'lat', 'long')">
                        <div class="card-body">
                            <p>9. Sesat Agung</p>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @include('layouts.modal._modal_apel')
@endsection
@push('js')
    <script type="text/javascript">
    $('#formApel').submit(async function(e) {
        e.preventDefault();
        $('#x-action').addClass('d-none');
    
        var data = new FormData(this);
        data.append('img', image);
        data.append('latLong', latLong);
        var param = {
            method: 'POST',
            url: '/user/presensi_apel/store',
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