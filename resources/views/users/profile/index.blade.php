@extends('layouts.pegawai.app')
@section('content')
<div id="appCapsule">
    <form action="/user/profile-information" method="POST" enctype="multipart/form-data">
        @method('PUT')
    @csrf
    <div class="section mt-3 text-center">
        <div class="avatar-section">
            {{-- <input type="file" onclick="openWebcame(0)" id="image"  class="upload" name="photo" id="avatar" accept=".jpeg, .jpg, .png"> --}}
            <img onclick="openWebcame(0)" id="imgPrev" src="{{ asset('storage/img/'. auth()->user()->photo) }}" alt="image" class="imaged w100">
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
                        <input type="text" class="form-control" value="{{ auth()->user()->opd->nama_opd }}" name="organisasi">
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
                <button id="btn_loading_profile" class="btn btn-primary btn-lg btn-block d-none" disabled type="button">
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
                    <button id="btn_loading_password" class="btn btn-primary btn-lg btn-block d-none" disabled type="button">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Tunggu sebentar yah...
                    </button>
                    <button id="btn_password" type="submit" class="btn-submit btn btn-primary mr-1 btn-lg btn-block mb-2">Simpan</button>
                </form>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                @if (auth()->user()->role == 'admin')
                <button onclick="redirect('/admin')" class="btn-submit btn btn-primary mr-1 btn-lg btn-block">Kelola Pegawai</button>
                <form action="/logout" method="POST">
                    @csrf
                    <button id="btn_password" type="submit" class="btn-submit btn btn-warning mr-1 btn-lg btn-block mt-2">Keluar</button>
                </form>
                @elseif(auth()->user()->role == 'oprator')
                <button onclick="redirect('/oprator')" class="btn-submit btn btn-primary mr-1 btn-lg btn-block">Kelola Pegawai</button>
                <form action="/logout" method="POST">
                    @csrf
                    <button id="btn_password" type="submit" class="btn-submit btn btn-warning mr-1 btn-lg btn-block mt-2">Keluar</button>
                </form>
                @else 
                <form action="/logout" method="POST">
                    @csrf
                    <button id="btn_password" type="submit" class="btn-submit btn btn-warning mr-1 btn-lg btn-block mt-2">Keluar</button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @include('layouts.modal._modal')
    @include('layouts.modal._modal_webcame')
</div>
@endsection
@push('js')
<script type="text/javascript">
var image = "";
function openWebcame() {
    //productoion
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    } else {
        swal({
            title: 'Oops!',
            text: 'Maaf, browser Anda tidak mendukung geolokasi HTML5.',
            icon: 'error',
            timer: 3000,
        });
    }

    function successCallback(position) {
        setWebcame();
    }

    function errorCallback(error) {
        if (error.code == 1) {
            swal({
                title: 'Oops!',
                text: 'Mohon untuk mengaktifkan lokasi Anda',
                icon: 'error',
                timer: 3000,
            });
        } else if (error.code == 2) {
            swal({
                title: 'Oops!',
                text: 'Jaringan tidak aktif atau layanan penentuan posisi tidak dapat dijangkau.',
                icon: 'error',
                timer: 3000,
            });
        } else if (error.code == 3) {
            swal({
                title: 'Oops!',
                text: 'Waktu percobaan habis sebelum bisa mendapatkan data lokasi.',
                icon: 'error',
                timer: 3000,
            });
        } else {
            swal({
                title: 'Oops!',
                text: 'Waktu percobaan habis sebelum bisa mendapatkan data lokasi.',
                icon: 'error',
                timer: 3000,
            });
        }
    }

    //set camera
    function setWebcame() {
        $('#modalWebcame').modal('show');
        Webcam.set({
            width: 490,
            height: 450,
            image_format: 'jpeg',
            jpeg_quality: 90,
        });

        var cameras = new Array();
        navigator.mediaDevices.enumerateDevices()
            .then(function(devices) {
                devices.forEach(function(device) {
                    var i = 0;
                    if (device.kind === "videoinput") {
                        cameras[i] = device.deviceId;
                        i++;
                    }
                });
            })

        Webcam.set('constraints', {
            width: 490,
            height: 450,
            image_format: 'jpeg',
            jpeg_quality: 90,
            sourceId: cameras[0]
        });

        Webcam.attach('.xwebcam-capture');
        shutter.autoplay = false;
        shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : '/assets/pegawai/shutter.mp3';
        document.getElementById('x-absent').setAttribute('onclick', 'captureimage()');
        }
    }

    function captureimage() {
        shutter.play();
        Webcam.snap(function(data_uri) {
            document.getElementById('webcameResult').innerHTML =
            `
            <img class="x-img-fluid" id="imageprev" style="border-radius: 15px" src="${data_uri}"/>
            `
            $('#registerFace').removeClass('d-none');
            Webcam.reset();
            return image = data_uri;
        });
        setTimeout(() => {
            removeFile(image);
        }, 60000);
    };

    $('#formRegisterFace').submit(async function(e) {
        e.preventDefault();
        var param = {
            method: 'POST',
            url: '/user/register-face',
            data: {
                face: image,
            }
        }

        await transAjax(param).then((result) => {
            console.log(result.success);
            if(result.success == true) {
            swal({
                title: 'Berhasil',
                text: result.message,
                icon: 'success',
                timer: 3000,
            });
            }
        }).catch((err) => {
            swal({
                title: 'Oops!',
                text: "Internal Server Error!",
                icon: 'error',
                timer: 3000,
            });
        });
    });

    $('#btn_profile').click(function() {
        $('#btn_profile').hide();
        $('#btn_loading_profile').removeClass('d-none');
    });

    $('#btn_password').click(function() {
        $('#btn_password').hide();
        $('#btn_loading_password').removeClass('d-none');
    });

    function redirect(url) {
        window.location.href = url+'/dashboard'
    }
</script>
@endpush