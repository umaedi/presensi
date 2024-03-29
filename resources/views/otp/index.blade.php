@extends('layouts.pegawai.auth')
@section('content')
<section class="section">
  <div class="mt-3">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand text-center my-3">
          <img src="{{ asset('img') }}/logo/logo-duluin.png" alt="logo" width="50%">
          <div class="mt-2">
              <h4>Verifikasi kode OTP</h4>
          </div>
        </div>
        <div class="card card-primary">
          <form id="sendOtp">
          <div class="card-body">
                @csrf
                <input type="hidden" name="key" value="{{ request()->key }}">
                <div class="form-group">
                  <label for="phone">{{ __('No WhatsApp') }}</label>
                  <input id="phone" type="text" class="form-control" name="phone" tabindex="1" required>
                </div>
            </div>
            <div class="form-button-group  transparent">
                <div id="loadingSubmit" class="row d-none">
                    <button class="btn btn-block btn-lg" style="background-color: #076759; color: #fff" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Tunggu sebentar yah...
                    </button>
                </div>
              <button type="submit" id="btnSubmit" class="btn btn-block btn-lg" style="background-color: #076759; color: #fff">KIRIM</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@push('js')
    <script type="text/javascript">
         $('#sendOtp').submit(async function(e) {
            e.preventDefault();
            loadingsubmit(true);

            let phone = $('#phone').val();
            var param = {
                url: '/send-otp/'+phone,
                method: 'POST',
            }

            await transAjax(param).then((res) => {
                loadingsubmit(false);
                window.location.href ='/verifikasi';
            }).catch((err) => {
                loadingsubmit(false);
                return alert('Internal Server Error!');
            });

            function loadingsubmit(state) {
                if (state) {
                    $('#btnSubmit').addClass('d-none');
                    $('#loadingSubmit').removeClass('d-none');
                } else {
                    $('#btnSubmit').removeClass('d-none');
                    $('#loadingSubmit').addClass('d-none');
                }
            }
        });
    </script>
@endpush

   

