@extends('layouts.pegawai.app')
@section('content')
    <div id="appCapsule">
        <div class="section wallet-card-section pt-1">
            <div class="wallet-card">
                <div class="balance">
                    <div class="left"><span class="title"> Anda login sebagai:</span>
                        <h3 class="total">{{ $nama[0] }}</h3>
                    </div>
                    <div class="right">
                        <span class="title">{{ \Carbon\Carbon::now()->format('d/m/Y') }} </span>
                        <h4><span class="clock">Loading...</span></h4>
                    </div>
                </div>
                <div class="wallet-footer">
                    <div class="item"><a href="/user/apel">
                            <div class="icon-wrapper bg-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 512 512">
                                    <path fill="#fff" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="32" d="M256 400V32l176 80-176 80" />
                                    <path
                                        d="M256 336c-87 0-175.3 43.2-191.64 124.74C62.39 470.57 68.57 480 80 480h352c11.44 0 17.62-9.43 15.65-19.26C431.3 379.2 343 336 256 336z"
                                        fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                                </svg>
                            </div>
                            <strong>Titik Kumpul</strong>
                        </a></div>
                    <div class="item"><a href="/user/izin">
                            <div class="icon-wrapper bg-warning">
                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" class="ionicon"
                                    viewBox="0 0 512 512">
                                    <rect fill="none" stroke="#fff" stroke-linejoin="round" stroke-width="32" x="48"
                                        y="80" width="416" height="384" rx="48" />
                                    <circle fill="#fff" cx="296" cy="232" r="24" />
                                    <circle fill="#fff" cx="376" cy="232" r="24" />
                                    <circle fill="#fff" cx="296" cy="312" r="24" />
                                    <circle fill="#fff" cx="376" cy="312" r="24" />
                                    <circle fill="#fff" cx="136" cy="312" r="24" />
                                    <circle fill="#fff" cx="216" cy="312" r="24" />
                                    <circle fill="#fff" cx="136" cy="392" r="24" />
                                    <circle fill="#fff" cx="216" cy="392" r="24" />
                                    <circle fill="#fff" cx="296" cy="392" r="24" />
                                    <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"
                                        stroke-linecap="round" d="M128 48v32M384 48v32" />
                                    <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"
                                        d="M464 160H48" />
                                </svg>
                            </div>
                            <strong>Cuti</strong>
                        </a></div>
                    <div class="item"><a href="/user/dl">
                            <div class="icon-wrapper bg-success">
                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" class="ionicon"
                                    viewBox="0 0 512 512">
                                    <path
                                        d="M53.12 199.94l400-151.39a8 8 0 0110.33 10.33l-151.39 400a8 8 0 01-15-.34l-67.4-166.09a16 16 0 00-10.11-10.11L53.46 215a8 8 0 01-.34-15.06zM460 52L227 285"
                                        fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="32" />
                                </svg>
                            </div><strong>DL</strong>
                        </a></div>
                    @if(count(auth()->user()->opd->subopd) > 0)
                    <div class="item"><a href="/user/subopd">
                        <div class="icon-wrapper bg-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 512 512">
                                <path fill="#fff" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="32" d="M256 400V32l176 80-176 80" />
                                <path
                                    d="M256 336c-87 0-175.3 43.2-191.64 124.74C62.39 470.57 68.57 480 80 480h352c11.44 0 17.62-9.43 15.65-19.26C431.3 379.2 343 336 256 336z"
                                    fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                            </svg>
                        </div>
                        <strong>Titik Tugas</strong>
                    </a>
                    </div>
                    @elseif(count(auth()->user()->opd->shift) > 0)
                    <div class="item"><a href="/user/shift">
                        <div class="icon-wrapper bg-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(243, 237, 237);transform: ;msFilter:;"><path d="M19.924 10.383a1 1 0 0 0-.217-1.09l-5-5-1.414 1.414L16.586 9H4v2h15a1 1 0 0 0 .924-.617zM4.076 13.617a1 1 0 0 0 .217 1.09l5 5 1.414-1.414L7.414 15H20v-2H5a.999.999 0 0 0-.924.617z"></path></svg>
                        </div>
                        <strong>Shift</strong>
                    </a>
                    </div>
                    @else
                    <div class="item"><a href="/user/scan">
                        <div class="icon-wrapper bg-primary">
                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" class="ionicon"
                                viewBox="0 0 512 512">
                                <rect x="336" y="336" fill="#fff" width="80" height="80" rx="8"
                                    ry="8" />
                                <rect x="272" y="272" fill="#fff" width="64" height="64" rx="8"
                                    ry="8" />
                                <rect x="416" y="416" fill="#fff" width="64" height="64" rx="8"
                                    ry="8" />
                                <rect x="432" y="272" fill="#fff" width="48" height="48" rx="8"
                                    ry="8" />
                                <rect x="272" y="432" fill="#fff" width="48" height="48" rx="8"
                                    ry="8" />
                                <rect x="336" y="96" fill="#fff" width="80" height="80" rx="8"
                                    ry="8" />
                                <rect x="288" y="48" width="176" height="176" rx="16" ry="16"
                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="32" />
                                <rect x="96" y="96" fill="#fff"width="80" height="80" rx="8"
                                    ry="8" />
                                <rect x="48" y="48" width="176" height="176" rx="16" ry="16"
                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="32" />
                                <rect x="96" y="336" fill="#fff" width="80" height="80" rx="8"
                                    ry="8" />
                                <rect x="48" y="288" width="176" height="176" rx="16" ry="16"
                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="32" />
                            </svg>
                        </div>
                        <strong>Scanner</strong>
                        </a>
                    </div>
                    @endisset
                </div>
            </div>
        </div>
        <div class="section">
            <div class="transactions">
                <div class="row mt-2">
                    @if (empty($absen->jam_masuk))
                        <div class="col-6">
                            {{-- <a href="/user/presensi"> --}}
                            <div class="stat-box bg-secondary">
                                <div class="title text-white">Presensi Masuk</div>
                                <div class="value text-white">Belum presensi</div>
                            </div>
                            {{-- </a> --}}
                        </div>
                    @else
                        <div class="col-6">
                            <div class="stat-box bg-primary">
                                <div class="title text-white">Presensi Masuk</div>
                                <div class="value text-white">Sudah presensi</div>
                            </div>
                        </div>
                    @endif

                    @if (empty($absen->jam_pulang))
                        <div class="col-6">
                            {{-- <a href="/user/presensi"> --}}
                            <div class="stat-box bg-secondary">
                                <div class="title text-white">Presensi Pulang</div>
                                <div class="value text-white">Belum presensi</div>
                            </div>
                            {{-- </a> --}}
                        </div>
                    @else
                        <div class="col-6">
                            <div class="stat-box bg-primary">
                                <div class="title text-white">Presensi Pulang</div>
                                <div class="value text-white">Sudah presensi</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="section mt-3">
            <div class="section-title mb-1">Presensi Bulan
                <select id="getBulan" class="select select-change text-primary" name="bulan" required>
                    <option value="01" {{ date('m') == '01' ? 'selected' : '' }}>Januari</option>
                    <option value="02" {{ date('m') == '02' ? 'selected' : '' }}>Februari</option>
                    <option value="03" {{ date('m') == '03' ? 'selected' : '' }}>Maret</option>
                    <option value="04" {{ date('m') == '04' ? 'selected' : '' }}>April</option>
                    <option value="05" {{ date('m') == '05' ? 'selected' : '' }}>Mei</option>
                    <option value="06" {{ date('m') == '06' ? 'selected' : '' }}>Juni</option>
                    <option value="07" {{ date('m') == '07' ? 'selected' : '' }}>Juli</option>
                    <option value="08" {{ date('m') == '08' ? 'selected' : '' }}>Agustus</option>
                    <option value="09" {{ date('m') == '09' ? 'selected' : '' }}>September</option>
                    <option value="10" {{ date('m') == '10' ? 'selected' : '' }}>Oktober</option>
                    <option value="12" {{ date('m') == '11' ? 'selected' : '' }}>November</option>
                    <option value="12" {{ date('m') == '12' ? 'selected' : '' }}>Desember</option>
                </select><span class="text-primary">{{ date('Y') }}</span>
            </div>
        </div>
        <div class="section mt-2 mb-2">
            <div class="transactions">
                <div class="row">
                    <div class="load-home" style="display:contents">
                        <div class="col-6 col-md-3 mb-2">
                            <a href="javascript:void(0)" class="item">
                                <div class="detail">
                                    <div class="icon-block text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 512 512">
                                            <path fill="#6777ef"
                                                d="M392 80H232a56.06 56.06 0 00-56 56v104h153.37l-52.68-52.69a16 16 0 0122.62-22.62l80 80a16 16 0 010 22.62l-80 80a16 16 0 01-22.62-22.62L329.37 272H176v104c0 32.05 33.79 56 64 56h152a56.06 56.06 0 0056-56V136a56.06 56.06 0 00-56-56zM80 240a16 16 0 000 32h96v-32z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <strong>Hadir</strong>
                                        <p>{{ $hadir }} Hari</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <a href="javascript:void(0)" class="item">
                                <div class="detail">
                                    <div class="icon-block text-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 512 512">
                                            <path fill="#FFB400"
                                                d="M414.39 97.61A224 224 0 1097.61 414.39 224 224 0 10414.39 97.61zM184 208a24 24 0 11-24 24 23.94 23.94 0 0124-24zm-23.67 149.83c12-40.3 50.2-69.83 95.62-69.83s83.62 29.53 95.71 69.83a8 8 0 01-7.82 10.17H168.15a8 8 0 01-7.82-10.17zM328 256a24 24 0 1124-24 23.94 23.94 0 01-24 24z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <strong>Cuti</strong>
                                        <p>{{ $cuti }} Hari</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-md-3">
                            <a href="javascript:void(0)" class="item">
                                <div class="detail">
                                    <div class="icon-block text-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 512 512">
                                            <path fill="#FF396F"
                                                d="M153.59 110.46A21.41 21.41 0 00152.48 79 62.67 62.67 0 00112 64l-3.27.09h-.48C74.4 66.15 48 95.55 48.07 131c0 19 8 29.06 14.32 37.11a20.61 20.61 0 0014.7 7.8c.26 0 .7.05 2 .05a19.06 19.06 0 0013.75-5.89zM403.79 64.11l-3.27-.1H400a62.67 62.67 0 00-40.52 15 21.41 21.41 0 00-1.11 31.44l60.77 59.65a19.06 19.06 0 0013.79 5.9c1.28 0 1.72 0 2-.05a20.61 20.61 0 0014.69-7.8c6.36-8.05 14.28-18.08 14.32-37.11.06-35.49-26.34-64.89-60.15-66.93z" />
                                            <path fill="#FF396F"
                                                d="M256.07 96c-97 0-176 78.95-176 176a175.23 175.23 0 0040.81 112.56l-36.12 36.13a16 16 0 1022.63 22.62l36.12-36.12a175.63 175.63 0 00225.12 0l36.13 36.12a16 16 0 1022.63-22.62l-36.13-36.13A175.17 175.17 0 00432.07 272c0-97-78.95-176-176-176zm16 176a16 16 0 01-16 16h-80a16 16 0 010-32h64v-96a16 16 0 0132 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <strong>Terlambat</strong>
                                        <p>{{ $terlambat }} hari</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="javascript:void(0)" class="item">
                                <div class="detail">
                                    <div class="icon-block text-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 512 512">
                                            <path
                                                d="M320 176v-40a40 40 0 00-40-40H88a40 40 0 00-40 40v240a40 40 0 0040 40h192a40 40 0 0040-40v-40M384 176l80 80-80 80M191 256h273"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="32" />
                                        </svg>
                                    </div>
                                    <div>
                                        <strong>DL</strong>
                                        <p>{{ $dl }} Hari</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-title mt-2">1 Minggu Terakhir</div>
            <div class="transactions" id="dataTable">

            </div>
        </div>
        {{-- modal --}}
        <div class="modal fade modalbox" id="modal-show" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">...</h5>
                        <a href="javascript:;" data-dismiss="modal">Close</a>
                    </div>
                    <div class="modal-body">
                        <div class="form-group basic">
                            <div class="input-wrapper text-center">
                                <img id="photoAbsen" class="img-fluid rounded" src="" alt="">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Nama</label>
                                <input type="text" class="form-control" id="name"
                                    value="{{ auth()->user()->nama }}" readonly><i class="clear-input"><ion-icon
                                        name="close-circle" role="img" class="md hydrated"
                                        aria-label="close circle"></ion-icon></i>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label datepicker">Tanggal</label>
                                <input name="tanggal" type="text" class="form-control" value="" readonly><i
                                    class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated"
                                        aria-label="close circle"></ion-icon></i>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Waktu Presensi</label>
                                <input name="jam_masuk" type="text" class="form-control" value="" readonly><i
                                    class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated"
                                        aria-label="close circle"></ion-icon></i>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Keterangan</label>
                                <input name="status" type="text" class="form-control" value="" readonly><i
                                    class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated"
                                        aria-label="close circle"></ion-icon></i>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Lokasi Saat Presensi</label>
                                <input name="latlong" type="text" class="form-control" value="" readonly><i
                                    class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated"
                                        aria-label="close circle"></ion-icon></i>
                            </div>
                            <div id="map" style="height: 390px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DialogIconedInfo -->
        <div class="modal fade dialogbox" id="DialogIconedInfo" data-bs-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-icon">
                        <ion-icon name="card-outline"></ion-icon>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="titleProses">...</h5>
                    </div>
                    <div class="modal-body" id="modalProses">
                        ...
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn" data-dismiss="modal">TUTUP</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * DialogIconedInfo -->

        {{-- penutupan aplikasi web --}}
          <!-- Modal Basic -->
          <div class="modal fade modalbox" id="ModalBasic" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">PENTING</h5>
                        <a href="javascript:;" data-dismiss="modal">Tutup</a>
                    </div>
                    <div class="modal-body">
                        <div class="text-dark">
                            <div class="font-weight-bold">Penutupan Total Akses Website Presensi Siap Tuba Mulai Tanggal 20 Maret 2024</div>
                            <br>
                            <div class="font-weight-bold">Tulang Bawang, 19 Maret 2024</div>
                            <br>
                            Berdasarkan hasil rapat Evaluasi Pelaksanaan Aplikasi Absensi SIAP TUBA,
                            Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Tulang Bawang memberitahukan kepada seluruh
                            pegawai kabupaten tulang bawang bahwa mulai tanggal 20 Maret 2024, akses ke website presensi Siap
                            Tuba
                            akan ditutup secara total. dan aktifitas presensi dialihkan menggunakan <b>Aplikasi SIAP TUBA</b>
                            yang dapat diunduh di Play Store. <br> <br>
                            Bagi pengguna iPhone tetap melakukan presensi menggunakan
                            <b>Safari</b>
                            <br><br>
                            <div class="font-weight-bold">Hormat kami,</div>
                            <br>
                            Tim Pengembang Dinas Komunikasi dan Informatika
                            Kabupaten Tulang Bawang
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Modal Basic -->

        {{-- modal selfi --}}
        @include('layouts.modal._modal')
    
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $('#ModalBasic').modal();
        $('#dataTable').html(make_skeleton());
        var bulan = '';
        $(document).ready(function() {
            loadData();

            $('#getBulan').change(function() {
                filterData();
            });
        });

        function filterData() {
            bulan = $('#getBulan').val();
            loadData();
        }

        async function loadData() {
            var param = {
                method: 'GET',
                url: '{{ url()->current() }}',
                data: {
                    load: 'table',
                    bulan: bulan,
                }
            }
            await transAjax(param).then((result) => {
                $('#dataTable').html(result)

            }).catch((err) => {
                console.log('error');
            });
        }

        function make_skeleton() {
            var output = '';
            for (var count = 0; count < 3; count++) {
                output += '<div class="col-12">';
                output += '<div class="ph-item">';
                output += '<div class="ph-picture"></div>';
                output += '</div>';
                output += '</div>';
            }
            return output;
        }

        jQuery(function($) {
            setInterval(function() {
                var date = new Date(),
                    time = date.toLocaleTimeString();
                $(".clock").html(time);
            }, 1000);
        });

        function showAbsen(data, waktu) {
            if (waktu === 1) {
                $('#modalTitle').html('Detail Absen Pagi');
                $('#photoAbsen').attr('src', "{{ asset('storage/users/img') }}/" + data.photo_masuk);
                $('input[name=tanggal]').val(data.tanggal);
                $('input[name=jam_masuk]').val(data.jam_masuk);
                $('input[name=status]').val(data.status);
                $('input[name=latlong]').val(data.lat_long_masuk);
            } else {
                $('#modalTitle').html('Detail Absen Sore');
                $('#photoAbsen').attr('src', "{{ asset('storage/users/img') }}/" + data.photo_pulang);
                $('input[name=tanggal]').val(data.tanggal);
                $('input[name=jam_masuk]').val(data.jam_pulang);
                $('input[name=status]').val(data.status_pulang);
                $('input[name=latlong]').val(data.lat_long_pulang);
            };

            const lat = data.lat_long_masuk.substring(10, '');
            const long = data.lat_long_masuk.substring(11);

            let mapOptions, map, marker;
            infoWindow = '';

            element = document.getElementById('map');

            mapOptions = {
                zoom: 16,
                center: {
                    lat: parseFloat(lat),
                    lng: parseFloat(long),
                },
                disableDefaultUI: false,
                scrollWheel: true,
                draggable: false,
            };

            map = new google.maps.Map(element, mapOptions);

            marker = new google.maps.Marker({
                position: mapOptions.center,
                map: map,
                // icon: 'http://pngimages.net/sites/default/files/google-maps-png-image-70164.png',
                draggable: true
            });
        }

        var info_proses = localStorage.getItem('info_proses');
        function showProses()
        {
            if(info_proses) {
                $('#titleProses').html('Sedang diproses')
                $('#modalProses').html('Data Anda sedang diproses')
            }else{
                $('#titleProses').html('Mohon maaf')
                $('#modalProses').html('Anda belum/tidak melakukan presensi sore!')
            }
            
        }

    </script>
@endpush
