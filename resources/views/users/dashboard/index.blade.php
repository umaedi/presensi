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
                    <span class="title">{{ \Carbon\Carbon::now()->format('d/m/Y') }} </span><h4><span class="clock">Loading...</span></h4>
                </div>
            </div>
            <div class="wallet-footer">
                <div class="item"><a href="/user/apel">
                        <div class="icon-wrapper bg-danger"><ion-icon name="golf-outline"></ion-icon></div>
                        <strong>Apel</strong>
                    </a></div>
                <div class="item"><a href="/user/izin">
                        <div class="icon-wrapper bg-warning"><ion-icon name="calendar-outline"></ion-icon></div>
                        <strong>Cuti</strong>
                    </a></div>
                <div class="item"><a href="/user/dl">
                        <div class="icon-wrapper bg-success"><ion-icon name="paper-plane-outline"></ion-icon>
                        </div><strong>DL</strong>
                    </a></div>
                <div class="item"><a href="/user/scan">
                        <div class="icon-wrapper bg-primary"><ion-icon name="qr-code-outline"></ion-icon></div>
                        <strong>Scanner</strong>
                    </a></div>
            </div>
        </div>
    </div>
    <div class="section">
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
        <div class="transactions"><div class="row"><div class="load-home" style="display:contents">
            <div class="col-6 col-md-3 mb-2">
                <a href="javascript:void(0)" class="item">
                    <div class="detail">
                        <div class="icon-block text-primary">
                            <ion-icon name="log-in" role="img" class="md hydrated" aria-label="log in"></ion-icon>
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
                            <ion-icon name="sad" role="img" class="md hydrated" aria-label="sad"></ion-icon>
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
                          <ion-icon name="alarm" role="img" class="md hydrated" aria-label="alarm"></ion-icon>
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
                            <ion-icon name="exit-outline"></ion-icon>
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
        <div class="card">
            <div class="table-responsive" id="x-data-table">
                
            </div>
        </div>
    </div>
    {{-- modal --}}
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
                                <input type="text" class="form-control" id="name" value="{{ auth()->user()->nama }}" readonly><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label datepicker">Tanggal</label>
                                <input name="tanggal" type="text" class="form-control" value="" readonly><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Waktu Presensi</label>
                                <input name="jam_masuk" type="text" class="form-control" value="" readonly><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Keterangan</label>
                                <input name="status" type="text" class="form-control" value="" readonly><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Lokasi Saat Presensi</label>
                                <input name="latlong" type="text" class="form-control" value="" readonly><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i>
                            </div>
                            <div id="map" style="height: 390px"></div>
                        </div>
                </div>
            </div>
        </div>
    </div>
     {{-- modal selfi--}}
    @include('layouts.modal._modal')
</div>
@endsection
@push('js')
    <script type="text/javascript">
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
                $('#x-data-table').html(result)

            }).catch((err) => {
                console.log('error');
        });
    }

    jQuery(function($) {
        setInterval(function() {
            var date = new Date(),
                time = date.toLocaleTimeString();
            $(".clock").html(time);
        }, 1000);
    });
    
    function showAbsen(data, waktu)
    {
        if(waktu === 1) {
            $('.modal-title').html('Detail Absen Pagi');
            $('#photoAbsen').attr('src', "{{ asset('storage/users/img') }}/"+ data.photo_masuk);
            $('input[name=tanggal]').val(data.tanggal);
            $('input[name=jam_masuk]').val(data.jam_masuk);
            $('input[name=status]').val(data.status);
            $('input[name=latlong]').val(data.lat_long_masuk);
        }else {
            $('.modal-title').html('Detail Absen Sore');
            $('#photoAbsen').attr('src', "{{ asset('storage/users/img') }}/"+ data.photo_pulang);
            $('input[name=tanggal]').val(data.tanggal);
            $('input[name=jam_masuk]').val(data.jam_pulang);
            $('input[name=status]').val(data.status);
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