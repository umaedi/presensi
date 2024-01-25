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
                                    <input id="tanggalAwal" type="text" class="form-control datepicker start_date" name="tanggal_awal" placeholder="Tanggal Awal" readonly>
                                    <div class="input-group-addon"><ion-icon name="calendar-outline" role="img" class="md hydrated" aria-label="calendar outline"></ion-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4  col-md-4">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <div class="input-group">
                                    <input id="tanggalAkhir" type="text" name="tanggal_akhir" placeholder="Tanggal Akhir" class="form-control datepicker end_date" readonly>
                                    <div class="input-group-addon"><ion-icon name="calendar-outline" role="img" class="md hydrated" aria-label="calendar outline"></ion-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4 justify-content-between">
                        <button id="tampilkan" type="button" class="btn btn-danger mt-1 btn-sortir"><ion-icon name="checkmark-outline" role="img" class="md hydrated" aria-label="checkmark outline"></ion-icon>Tampilkan</button>
                        <button id="printPage" class="btn btn-warning mt-1"><ion-icon name="print-outline" role="img" class="md hydrated" aria-label="print outline"></ion-icon> Cetak</button>
                        <button id="btnClear" type="button" class="btn btn-success mt-1 btn-clear"><ion-icon name="repeat-outline" role="img" class="md hydrated" aria-label="repeat outline"></ion-icon> Clear</button>
                    </div>  
                </div>
            </div>
        </div>
    </div>
<div class="section mt-2">
    <div class="section-title">Data Presensi</div>
    <div class="card">
        <div class="card">
            @include('layouts.pegawai._loading')
            <div class="table-responsive" id="x-data-table">
                
            </div>
        </div>
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
@include('layouts.modal._modal')
@endsection
@push('js')
<script type="text/javascript" src="{{ asset('assets/pegawai') }}/js/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">

    var page  = 1;
    var tanggalAwal = '';
    var tanggalAkhir = '';
    var terlambat = '';
    var dl = '';
    var cuti = '';

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

    function filterData(){
       tanggalAwal = $('#tanggalAwal').val();
       tanggalAkhir =  $('#tanggalAkhir').val();
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
        
        loading(true);
        await transAjax(param).then(function(result) {
            loading(false)
            $('#x-data-table').html(result)
        }).catch((err) => {
            loading(false)
            console.log('Internal Server Error!');
        });
    }

    function loading(state) {
        if(state) {
            $('#loading').removeClass('d-none');
        } else {
            $('#loading').addClass('d-none');
        }
    }

    function loadPaginate(to) {
        page = to
        filterData()
    }

    $(".datepicker").datepicker({
        format: "dd-mm-yyyy",
        "autoclose": true
    });

    function printPage(){
        var tanggalAwal = $('#tanggalAwal').val();
        var tanggalAkhir = $('#tanggalAkhir').val();
        window.location.href = "/user/history/print?tanggal_awal="+tanggalAwal+"&tanggal_akhir="+tanggalAkhir;
    }

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