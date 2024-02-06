@extends('layouts.main')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-8 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-8">
              <div class="card-body">
                <h5 class="card-title text-primary">Selamat datang di dashboard SIAP TUBA</h5>
                <p class="mb-4">
                  Sistem Informasi Presensi Tulang Bawang
                </p>
              </div>
            </div>
            <div class="col-sm-4 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img loading="lazy"
                  src="{{ asset('img') }}/illustrations/man-with-laptop-light.png"
                  height="140"
                  alt="View Badge User"
                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                  data-app-light-img="illustrations/man-with-laptop-light.png"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img loading="lazy"
                      src="{{ asset('img') }}/icons/icon-fingerprint.png"
                      alt="chart success"
                      class="rounded"
                    />
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Pegawai</span>
                <h3 class="card-title mb-2">{{ $user }}</h3>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img loading="lazy"
                      src="{{ asset('img') }}/icons/icon-fingerprint.png"
                      alt="chart success"
                      class="rounded"
                    />
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Presensi</span>
                <h3 class="card-title mb-2">{{ $presensi }}</h3>
              </div>
            </div>
          </div>

        </div>
      </div>
      <!-- Total Revenue -->
      <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
        <button type="button" class="btn btn-primary mb-3" id="sudahPresensi">
          Pegawai yang sudah melakukan presensi <span class="badge bg-warning">{{ $sudahPresensi }}</span>
        </button>
        <button type="button" class="btn btn-primary mb-3" id="belumPresensi">
          Pegawai yang belum melakukan presensi <span class="badge bg-warning">{{ $belumPresensi }}</span>
        </button>
        <div class="card">
          <h5 class="card-header">PRESENSI PEGAWAI <span class="text-uppercase">{{ $tanggal }}</span></h5>
          <div class="card-body">
            <div class="table-responsive text-nowrap">
              @include('layouts._loading')
              <div class="table-responsive text-nowrap" id="dataTable">

              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/ Total Revenue -->
    </div>
  </div>
    <!-- Modal -->
    <div class="modal fade modalbox" id="modal-show" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
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
    <script type="text/javascript">
    var page = 1;
    var sudahPresensi = '';
    var belumPresensi = '';
    var search = '';
        $(document).ready(function() {
          loadTable();

          $('#search').on('keypress', function(e) {
                if(e.which == 13) {
                    filterTable();
                    return false;
                }
            });

          $('#sudahPresensi').click(function() {
            filterTable('sudah_presensi');
          });

          $('#belumPresensi').click(function() {
            filterTable('belum_presensi');
          });

        });

        function filterTable(value) {
          console.log(value);
            search = $('#search').val();
            sudahPresensi = value;
            belumPresensi = value;
            loadTable();
        }

        async function loadTable()
        {
          var param = {
            url: '{{ url()->current() }}',
            method: 'GET',
            data: {
              load: 'table',
              sudah_presensi:  sudahPresensi,
              belum_presensi:  belumPresensi,
              page: page,
              search: search
            }
          }
          loading(true);
          await transAjax(param).then((result) => {
            loading(false);
            $('#dataTable').html(result);
          }).catch((err) => {
            loading(false);
            console.log(err);
          });
        }

        function loadPaginate(to) {
          page = to;
          loadTable();
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
