<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="JNUql3k5Q0B10HhKDHMUZRMQb9Z23lLwY3oLqiCAJH0" />
    <title>{{ $title ?? 'Dashboard' }}</title>

    <meta name="theme-color" content="#6777ef">
    <meta name="msapplication-navbutton-color" content="#6777ef">
    <meta name="apple-mobile-web-app-status-bar-style" content="#6777ef">
    <meta name="description" content="DISKOMINFO TUBA">
    <meta name="keywords" content="DISKOMINFO TUBA">
    <meta name="author" content="DISKOMINFO TUBA">
    <meta http-equiv="Copyright" content="DISKOMINFO TUBA">
    <meta name="copyright" content="DISKOMINFO TUBA">

    <link rel="stylesheet" href="{{ asset('assets/pegawai') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('assets/pegawai') }}/css/sw-custom.css">
    <link rel="stylesheet" href="{{ asset('css') }}/placeholder-loading.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- PWA  -->
    <link rel="apple-touch-icon" href="{{ asset('assets/icon/lc_icon_presensi.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    {{-- @livewireStyles --}}

</head>

<body>
    <div class="x-container">
        @yield('content')
        @include('layouts.pegawai.navbar')
        @include('layouts.pegawai.button-action')
        @include('layouts.pegawai.footer')
    </div>
    
    <script src="{{ asset('assets/pegawai') }}/js/lib/jquery-3.4.1.min.js"></script>
    <script src="https://kit.fontawesome.com/0ccb04165b.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/pegawai') }}/js/sweetalert.min.js"></script>
    <script src="{{ asset('assets/pegawai') }}/js/webcamjs/webcam.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAD8y5ZQcuol7vxOkXii_wsHqYhCNL0uEM&libraries=geometry&callback&places">
    </script>
    <script type="text/javascript" src="{{ asset('assets/pegawai') }}/js/plugins/datepicker/bootstrap-datepicker.js"></script>
    {{-- @vite(['resources/js/app.js']) --}}
    <script type="text/javascript">
        $(document).ready(function loading() {
            sw();
        });

        function sw() {
            if (!navigator.serviceWorker.controller) {
                navigator.serviceWorker.register("/sw.js").then(function(reg) {
                    console.log("Service worker has been registered for scope: " + reg.scope);
                });
            }
        }

        async function transAjax(data) {
            html = null;
            data.headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            await $.ajax(data).done(function(res) {
                    html = res;
                })
                .fail(function() {
                    return false;
                })
            return html
        }

        function loading(btn_submit, btn_loading) {
            $('#' + btn_submit).addClass('d-none');
            $('#' + btn_loading).removeClass('d-none');
        }

        //camera
        var latLong = "";
        var image = "";
        var status = "";
        var shutter = new Audio();
        var cureentDate = new Date();
        var userId = "{{ auth()->user()->id }}"


        function openCamera(status, lat, long) {
            var perangkatId = localStorage.getItem('perangkatId');
            var presensiDate = localStorage.getItem('presensiDate');

            if(presensiDate !== "" && presensiDate == cureentDate.getDate()) {
                if(perangkatId !== userId) {
                    swal({
                    title: 'Oops!',
                    text: 'Satu Perangkat hanya bisa digunakan satu akun!',
                    icon: 'error',
                    });
                return;
                }
            }

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
                if (status == 1) {
                    setCamera();
                    return latLong = "" + position.coords.latitude + "," + position.coords.longitude + "";
                } else {
                    getCurrentPosition(position);
                    return latLong = "" + position.coords.latitude + "," + position.coords.longitude + "";
                }
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

            function getCurrentPosition(position) {
                if (status == 2) {
                    swal({
                        title: 'Oops!',
                        text: 'Silakan pilih salah satu lokasi/shift diatas!',
                        icon: 'error',
                        timer: 5000,
                    });
                    return;
                }

                if (status == 3) {
                    swal({
                        title: 'Oops!',
                        text: 'Lokasi kegiatan tidak aktif!',
                        icon: 'error',
                        timer: 3000,
                    });
                    return;
                }

                if(status === 4) {
                    var currentLocation = {
                        lat: lat,
                        lng: long,
                    };
                }else {
                    var currentLocation = {
                        lat: {{ auth()->user()->opd->lat }},
                        lng: {{ auth()->user()->opd->long }}
                    };
                }
                
                var userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                var radius = 300;
                var distance = google.maps.geometry.spherical.computeDistanceBetween(
                    new google.maps.LatLng(currentLocation),
                    new google.maps.LatLng(userLocation)
                );

                if (distance < radius) {
                    setCamera();
                } else {
                    setCamera();
                    // swal({
                    //     title: 'Oops!',
                    //     text: 'Mohon Maaf Sepertinya Anda Diluar Radius!',
                    //     icon: 'error',
                    //     timer: 5000,
                    // }).then(() => {
                    //     window.location.href = '{{ url()->current() }}';
                    // });
                }
            }
            //production end

            //set camera
            function setCamera() {
                $('#modalSelfi').modal('show');
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

                Webcam.attach('.webcam-capture');
                shutter.autoplay = false;
                shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : '/assets/pegawai/shutter.mp3';
                document.getElementById('x-absent').setAttribute('onclick', 'captureimage()');
            }
        }

        function captureimage() {
            shutter.play();
            Webcam.snap(function(data_uri) {
                faceCheck(data_uri);
                document.getElementById('results').innerHTML =
                `
                <img class="x-img-fluid" id="imageprev" style="border-radius: 15px" src="${data_uri}"/>
                `
                $('#x-action').removeClass('d-none');
                Webcam.reset();
                document.getElementById('x-resetCamera').setAttribute('onclick', 'resetCamera()');
                return image = data_uri;
            });
            setTimeout(() => {
                removeFile(image);
            }, 60000);
        }

        function resetCamera() {
            removeFile(image);
        }

        if("{{ auth()->user()->opd_id == '49' }}") {
            var _url = '/user/presensi/rsud/store';
        }else {
            var _url = '/user/presensi/store';
        }
        async function absenStore() {
            $('#x-action').addClass('d-none');
            var param = {
                method: 'POST',
                url: _url,
                data: {
                    latLong: latLong,
                    file: image,
                }
            }

            loadingsubmit(true);
            await transAjax(param).then((res) => {
                loadingsubmit(false);

                if(res.metadata.presensi_pagi == true) {
                    localStorage.removeItem('info_proses');
                    localStorage.setItem('perangkatId', res.metadata.perangkatId);
                    localStorage.setItem('presensiDate', cureentDate.getDate())
                }else {
                    localStorage.setItem('info_proses', 'presensi sore sedang diproses');
                }

                swal({
                    text: res.message,
                    icon: 'success',
                    timer: 3000,
                }).then(() => {
                    window.location.href = '/user/dashboard';
                });
            }).catch((err) => {
                loadingsubmit(false);
                swal({
                    text: err.responseJSON.message,
                    icon: 'error',
                    timer: 5000,
                }).then(() => {
                    removeFile(image);
                });
            });
        }

        function loadingsubmit(state) {
            if (state) {
                $('#loadingSubmit').removeClass('d-none');
            } else {
                $('#loadingSubmit').addClass('d-none');
                $('#x-action').removeClass('d-none');
            }
        }

        async function faceCheck(file) {
            var param = {
                method: 'POST',
                url: '/user/presensi/face_check',
                data: {
                    image: file,
                }
            }

            $('#btnIsiPresensi').addClass('d-none');
            $('#faceCheck').removeClass('d-none');

            // submitFile(file);
            await transAjax(param).then((res) => {
                const responseData = JSON.parse(res.data);
                const message = responseData.message;

                if(message == "Face verification successful!") {
                    submitFile(file);
                    $('#btnIsiPresensi').removeClass('d-none');
                    $('#faceCheck').addClass('d-none');
                }else {
                    swal({
                    text: message,
                    icon: 'error',
                }).then(() => {
                    window.location.href = "/user/dashboard";
                    });
                }
            }).catch((err) => {
                const errMessage = JSON.parse(res.message);
                swal({
                    text: errMessage,
                    icon: 'error',
                }).then(() => {
                    window.location.href = "/user/dashboard";
                });
            });
        }

        async function submitFile(file) {
            var param = {
                method: 'POST',
                url: '/user/presensi/store_file',
                data: {
                    image: file,
                }
            }

            await transAjax(param).then((res) => {
                if(res.metadata) {
                    return image = res.metadata;
                }
            }).catch((err) => {
                console.log(err);
            });
        }

        async function removeFile(file) {
            var param = {
                method: 'POST',
                url: '/user/presensi/remove_file',
                data: {
                    file: file,
                }
            }

            await transAjax(param).then((res) => {
                window.location.href = '{{ url()->current() }}';
            }).catch((err) => {
                window.location.href = '{{ url()->current() }}';
            });
        }
        
        $(".datepicker").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
    </script>
    @stack('js')
    <script type="module">
        import hotwiredTurbo from 'https://cdn.skypack.dev/pin/@hotwired/turbo@v7.3.0-44BiCcz1UaBhgMf1MCRj/mode=imports,min/optimized/@hotwired/turbo.js';
    </script>
</body>
</html>