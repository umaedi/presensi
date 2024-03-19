@extends('layouts.pages')
@section('content')
    <div id="appCapsule">
        <div class="rounded section mt-2 col-md-6 mx-auto bg-white p-3">
            <div class="row">
                <div class="col-md-6 d-flex justify-content-center">
                    <img width="auto" height="300" src="{{ asset('assets/pegawai/img/illustration.png') }}" alt="">
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div>
                        <h2>Maaf! anda tidak dapat melakukan presensi pada website ini.</h2>
                        <p>Gunakan aplikasi SIAP TUBA untuk melakukan presensi.</p>
                        <p></p>
                        <a href="https://play.google.com/store/apps/details?id=com.tulangbawangkab.siaptuba"
                            class="btn btn-primary my-2">Play Store</a>
                        <br>
                        <hr>
                        <span class="d-flex">
                            Masuk sebagai
                            pengguna &nbsp;
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-toggle="dropdown"
                                    aria-expanded="false">
                                    -- Pilih --
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('/user/dashboard') }}">iPhone</a>
                                    <a class="dropdown-item" href="{{ url('/admin/dashboard') }}">Super Admin</a>
                                    <a class="dropdown-item" href="{{ url('/oprator/dashboard') }}">Operator</a>
                                </div>
                            </div>

                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
@endsection
