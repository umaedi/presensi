@extends('layouts.main')
@section('content')
<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-4">
        <!-- Basic Alerts -->
        <div class="col-md mb-4 mb-md-0">
            <div class="card">
                <h5 class="card-header">Presensi Pegawai</h5>
                <div class="card-body">
                @include('layouts._loading')
                <div class="table-responsive text-nowrap" id="dataTable">
                    
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade modalbox" id="modal-show" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Detail Presensi</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
                <div class="row g-2">
                <div class="col-12 col-md-4 mb-0">
                    <img id="photoAbsen" class="img-fluid rounded" src="" alt="">
                </div>
                <div class="col-12 col-md-8 mb-0">
                    <div class="form-group mb-3">
                    <label for="dobExLarge" class="form-label">Nama</label>
                    <input type="text" id="dobExLarge" class="form-control" name="nama" />
                    </div>
                    <div class="form-group mb-3">
                    <label for="dobExLarge" class="form-label">Tanggal</label>
                    <input type="text" id="dobExLarge" class="form-control" name="tanggal" />
                    </div>
                    <div class="form-group mb-3">
                    <label for="dobExLarge" class="form-label">Waktu Presensi</label>
                    <input type="text" id="dobExLarge" class="form-control" name="jam_masuk" />
                    </div>
                    <div class="form-group mb-3">
                    <label for="dobExLarge" class="form-label">Lokasi Saat Presensi</label>
                    <input type="text" id="dobExLarge" class="form-control" name="latlong" />
                    </div>
                </div>
                </div>
                <div class="row">
                <div class="form-group">
                    <div id="map" style="height: 390px"></div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAD8y5ZQcuol7vxOkXii_wsHqYhCNL0uEM&libraries=geometry&callback"></script>
    <script>
        var search = '';
        var page = 1;
        $(document).ready(function() {
            loadTable();

            $('#search').on('keypress', function(e) {
                if(e.which == 13) {
                    filterTable();
                    return false;
                }
            });
        });

        function filterTable() {
            search = $('#search').val();
            loadTable();
        }

        async function loadTable()
        {
            var param = {
                url: '{{ url()->current() }}',
                method: 'GET',
                data: {
                    load: 'table',
                    search: search,
                    page: page,
                }
            }
            
            loading(true);
            await transAjax(param).then((result) => {
                loading(false);
                $('#dataTable').html(result);
            }).catch((err) => {
                loading(false);
                console.log(err);
            })
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
        filterTable()
        }
        function showPresensi(data, waktu)
        {
            if(waktu === 1) {
                $('.modal-title').html('Detail Presensi Pagi');
                $('#photoAbsen').attr('src', "{{ asset('storage/users/img') }}/"+ data.photo_masuk);
                $('input[name=nama]').val(data.user.nama);
                $('input[name=tanggal]').val(data.tanggal);
                $('input[name=jam_masuk]').val(data.jam_masuk);
                $('input[name=latlong]').val(data.lat_long_masuk);
            }else {
                $('.modal-title').html('Detail Presensi Sore');
                $('#photoAbsen').attr('src', "{{ asset('storage/users/img') }}/"+ data.photo_pulang);
                $('input[name=nama]').val(data.user.nama);
                $('input[name=tanggal]').val(data.tanggal);
                $('input[name=jam_masuk]').val(data.jam_pulang);
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

