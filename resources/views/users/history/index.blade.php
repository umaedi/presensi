@extends('layouts.pegawai.app')
@section('content')
    <div id="appCapsule">
        <div class="section mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <div class="input-group">
                                        <input id="tanggalAwal" type="text" class="form-control datepicker start_date"
                                            name="tanggal_awal" placeholder="Tanggal Awal" readonly>
                                        <div class="input-group-addon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon-sm"
                                                viewBox="0 0 512 512">
                                                <rect fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="32" x="48" y="80" width="416" height="384"
                                                    rx="48" />
                                                <circle fill="currentColor" cx="296" cy="232" r="24" />
                                                <circle fill="currentColor" cx="376" cy="232" r="24" />
                                                <circle fill="currentColor" cx="296" cy="312" r="24" />
                                                <circle fill="currentColor" cx="376" cy="312" r="24" />
                                                <circle fill="currentColor" cx="136" cy="312" r="24" />
                                                <circle fill="currentColor" cx="216" cy="312" r="24" />
                                                <circle fill="currentColor" cx="136" cy="392" r="24" />
                                                <circle fill="currentColor" cx="216" cy="392" r="24" />
                                                <circle fill="currentColor" cx="296" cy="392" r="24" />
                                                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="32" stroke-linecap="round" d="M128 48v32M384 48v32" />
                                                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="32" d="M464 160H48" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4  col-md-4">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <div class="input-group">
                                        <input id="tanggalAkhir" type="text" name="tanggal_akhir"
                                            placeholder="Tanggal Akhir" class="form-control datepicker end_date" readonly>
                                        <div class="input-group-addon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon-sm"
                                                viewBox="0 0 512 512">
                                                <rect fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="32" x="48" y="80" width="416" height="384"
                                                    rx="48" />
                                                <circle fill="currentColor" cx="296" cy="232" r="24" />
                                                <circle fill="currentColor" cx="376" cy="232" r="24" />
                                                <circle fill="currentColor" cx="296" cy="312" r="24" />
                                                <circle fill="currentColor" cx="376" cy="312" r="24" />
                                                <circle fill="currentColor" cx="136" cy="312" r="24" />
                                                <circle fill="currentColor" cx="216" cy="312" r="24" />
                                                <circle fill="currentColor" cx="136" cy="392" r="24" />
                                                <circle fill="currentColor" cx="216" cy="392" r="24" />
                                                <circle fill="currentColor" cx="296" cy="392" r="24" />
                                                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="32" stroke-linecap="round" d="M128 48v32M384 48v32" />
                                                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="32" d="M464 160H48" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 justify-content-between">
                            <button id="tampilkan" type="button" class="btn btn-primary mt-1 btn-sortir">
                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon-xs" viewBox="0 0 512 512">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="32" d="M416 128L192 384l-96-96" />
                                </svg>Tampilkan</button>
                            <button id="printPage" class="btn btn-warning mt-1"><svg xmlns="http://www.w3.org/2000/svg"
                                    class="svg-icon-xs" viewBox="0 0 512 512">
                                    <path
                                        d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24"
                                        fill="none" stroke="currentColor" stroke-linejoin="round"
                                        stroke-width="32" />
                                    <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32"
                                        fill="none" stroke="currentColor" stroke-linejoin="round"
                                        stroke-width="32" />
                                    <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24"
                                        fill="none" stroke="currentColor" stroke-linejoin="round"
                                        stroke-width="32" />
                                    <circle cx="392" cy="184" r="24" />
                                </svg>
                                Cetak</button>
                            <button id="btnClear" type="button" class="btn btn-success mt-1 btn-clear">
                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon-xs" viewBox="0 0 512 512">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="32" d="M320 120l48 48-48 48" />
                                    <path d="M352 168H144a80.24 80.24 0 00-80 80v16M192 392l-48-48 48-48" fill="none"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="32" />
                                    <path d="M160 344h208a80.24 80.24 0 0080-80v-16" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                </svg> Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2">
            <div class="section-title">Data Presensi</div>
            {{-- @include('layouts.pegawai._loading') --}}
            <div class="transactions" id="dataTable">

            </div>
        </div>
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-3">
                    <p>Hadir : <span class="badge badge-success">{{ $hadir }}</span></p>
                </div>

                <div class="col-md-3">
                    <p id="terlambat">Terlambat : <span class="label badge badge-danger">{{ $terlambat }}</span></p>
                </div>

                <div class="col-md-3">
                    <p id="dl">DL : <span class="badge badge-warning">{{ $dl }}</span></p>
                </div>

                <div class="col-md-3">
                    <p id="cuti">Apel : <span class="badge badge-info">{{ $apel }}</span></p>
                </div>
            </div>

        </div>

        <div class="modal fade modalbox" id="modal-show" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">...</h5>
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
        @include('layouts.modal._modal')
    @endsection
    @push('js')
        <script type="text/javascript" src="{{ asset('assets/pegawai') }}/js/plugins/datepicker/bootstrap-datepicker.js">
        </script>
        <script type="text/javascript">
            var page = 1;
            var tanggalAwal = '';
            var tanggalAkhir = '';
            var terlambat = '';
            var dl = '';
            var cuti = '';

            $('#dataTable').html(make_skeleton());
            $(document).ready(function() {
                loadData();
                $('#tampilkan').click(function() {
                    filterData();
                });

                $('#terlambat').click(function() {
                    filterData();
                });

                $('#dl').click(function() {
                    filterData();
                });

                $('#cuti').click(function() {
                    filterData();
                });

                $('#btnClear').click(function() {
                    $('input').val('');
                    filterData();
                });

                $('#printPage').click(function() {
                    printPage();
                });
            });

            function filterData() {
                tanggalAwal = $('#tanggalAwal').val();
                tanggalAkhir = $('#tanggalAkhir').val();
                terlambat = 'terlambat';
                loadData();
            }

            async function loadData() {
                var param = {
                    method: 'GET',
                    url: '{{ url()->current() }}',
                    data: {
                        load: 'table',
                        page: page,
                        tanggal_awal: tanggalAwal,
                        tanggal_akhir: tanggalAkhir,
                    }
                }

                await transAjax(param).then(function(result) {
                    $('#dataTable').html(result)
                }).catch((err) => {
                    console.log('Internal Server Error!');
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

            function loadPaginate(to) {
                page = to
                filterData()
            }

            $(".datepicker").datepicker({
                format: "dd-mm-yyyy",
                "autoclose": true
            });

            function printPage() {
                var tanggalAwal = $('#tanggalAwal').val();
                var tanggalAkhir = $('#tanggalAkhir').val();
                window.location.href = "/user/history/print?tanggal_awal=" + tanggalAwal + "&tanggal_akhir=" + tanggalAkhir;
            }

            function showAbsen(data, waktu) {
                if (waktu === 1) {
                    $('.modal-title').html('Detail Absen Pagi');
                    $('#photoAbsen').attr('src', "{{ asset('storage/users/img') }}/" + data.photo_masuk);
                    $('input[name=tanggal]').val(data.tanggal);
                    $('input[name=jam_masuk]').val(data.jam_masuk);
                    $('input[name=status]').val(data.status);
                    $('input[name=latlong]').val(data.lat_long_masuk);
                } else {
                    $('.modal-title').html('Detail Absen Sore');
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
        </script>
    @endpush
