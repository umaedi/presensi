@extends('layouts.pegawai.auth')
@section('content')
<div id="appCapsule">
    <div class="section mt-2 text-center">
        <img src="{{ asset('img') }}/logo/logo-duluin.png" alt="logo" width="50%">
        <h2 class="mt-2">Kode OTP</h2>
        <h5>Masukan 4 digit kode OTP untuk memverifikasi Akun Anda</h5>
    </div>
    <div class="section mb-5 p-2">
        <form action="https://finapp.bragherstudio.com/view3/index.html">
            <div class="form-group basic">
                <input type="text" class="form-control verification-input" id="smscode" placeholder="••••"
                    maxlength="4">
            </div>

            <div class="form-button-group transparent">
                <a href="https://gajian.duluin.com/" type="submit" class="btn btn-block btn-lg" style="background-color: #076759; color: #fff">Verifikasi</a>
            </div>

        </form>
    </div>

</div>
@endsection