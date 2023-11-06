@extends('layouts.pegawai.auth')
@section('content')
<section class="section">
  <div class="mt-3">
    <div class="row">
      <div class="col-8 col-sm-8 offset-sm-2 col-md-4 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="card card-primary text-center">
          <div class="card-header"><h4>{{ __('QR CODE') }}</h4></div>
          <div class="card-body">
            <img src="{{ asset('assets/pegawai/qrcode/qrcode.png') }}" alt="" width="100%">
          </div>
        </div>
        <div class="simple-footer text-center mt-3">
          {{ __('Copyright') }} &copy; {{ date('Y') }}
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

   

