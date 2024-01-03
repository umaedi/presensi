@extends('layouts.pegawai.app')
@section('content')
<div id="appCapsule">
    <form action="/user/profile-information" method="POST" enctype="multipart/form-data">
        @method('PUT')
    @csrf
    <div class="section mt-3 text-center">
        <div class="avatar-section">
            <input type="file" onchange="previewImg()" id="image"  class="upload" name="photo" id="avatar" accept=".jpeg, .jpg, .png">
            <img  id="imgPrev" src="{{ \Illuminate\Support\Facades\Storage::url(auth()->user()->photo) }}" alt="image" class="imaged w100 rounded"><span class="button"><ion-icon name="camera-outline" role="img" class="md hydrated" aria-label="camera outline"></ion-icon></span>
        </div>
    </div>
    <div class="section mt-2 mb-2">
      @if (session('status'))
        <div class="alert alert-success">
        @if (session('status')=='profile-information-updated')
        Profil berhasil diperbaharui.
        @endif
        @if (session('status')=='password-updated')
        Password berhasil diperbaharui.
        @endif
        @if (session('status')=='two-factor-authentication-disabled')
        Two factor authentication disabled.
        @endif
        @if (session('status')=='two-factor-authentication-enabled')
        Two factor authentication enabled.
        @endif
        @if (session('status')=='recovery-codes-generated')
        Recovery codes generated.
        @endif
      </div>
      @endif
        <div class="section-title">Profil</div>
        <div class="card">
            <div class="card-body boxed">
                <div class="form-group">
                    <div class="input-wrapper">
                        <label class="label" for="text4">NIP</label>
                        <input type="text" class="form-control" required value="{{ auth()->user()->nip }}" name="nip">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-wrapper">
                        <label class="label" for="email4">Nama</label>
                        <input type="text" class="form-control" id="name" value="{{ auth()->user()->nama }}" name="nama">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-wrapper">
                        <label class="label" for="password4">Organisasi</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->organisasi }}" name="organisasi">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-wrapper">
                        <label class="label" for="password4">Nama OPD</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->opd->nama_opd }}" name="nama_opd">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-wrapper">
                        <label class="label" for="password4">Unit Organisasi</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->unit_organisasi }}" name="unit_organisasi">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-wrapper">
                        <label class="label" for="select4">Jabatan</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->jabatan }}" name="jabatan">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-wrapper">
                        <label class="label" for="no_tlp">No Tlp</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->no_hp }}" name="no_hp">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-wrapper">
                        <label class="label" for="email">Email</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->email }}" name="email">
                    </div>
                </div>
                <hr>
                <button id="btn_loading" class="btn btn-primary btn-lg btn-block d-none" type="button">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Tunggu sebentar yah...
                </button>
                <button id="btn_profile" type="submit" class="btn-submit btn btn-primary mr-1 btn-lg btn-block btn-profile">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    <div class="section mt-2 mb-2">
        <div class="section-title">Update Password</div>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('user-password.update') }}">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Password saat ini</label>
                        <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" tabindex="3">
                        @error('current_password')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="gender">Password Baru</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="3">
                        @error('password')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="gender">Konfirmasi password</label>
                        <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" tabindex="3">
                        @error('password_confirmation')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    <hr>
                    <button id="btn_password" type="submit" class="btn-submit btn btn-primary mr-1 btn-lg btn-block">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.modal._modal')
</div>
@endsection
@push('js')
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAD8y5ZQcuol7vxOkXii_wsHqYhCNL0uEM&libraries=geometry&callback"></script>
<script type="text/javascript" src="{{ asset('assets/js/camera.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {


   $('#btn_profile').on('submit', function() {
        $('btn_loading').removeClass('d-none');
   });

    $('#update-password').submit(async function updatePassword(e) {
        e.preventDefault();

        var form 	= $(this)[0]; 
		var data 	= new FormData(form);

        var param = {
            method: 'POST',
            url: '/pegawai/profile/update/password',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
        }

        loadingsubmit(true);
        await transAjax(param).then((res) => {
        swal({text: res.message, icon: 'success', timer: 3000,}).then(() => {
            loadingsubmit(false);
            window.location.href = '/pegawai/dashboard';
        });
    }).catch((err) => {
        loadingsubmit(false);
            swal({text: err, icon: 'error', timer: 3000,}).then(() => {
            window.location.href = '/pegawai/profile';
            });
        });  
    });

    function loadingsubmit(state){
        if(state) {
            $('#btn_loading_password').removeClass('d-none');
            $('#btn_password').addClass('d-none');
        }else {
            $('#btn_loading_password').addClass('d-none');
            $('#btn_password').removeClass('d-none');
        }
    }  
 
});

function previewImg(){
        const imgPreview = document.querySelector('#imgPrev');
        const image = document.querySelector('#image');
        const blob = URL.createObjectURL(image.files[0]);
        imgPreview.src = blob; 
    }
</script>
@endpush