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
                  Sistem Informasi Presensi Pegawai Kabupaten Tulang Bawang
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
            <a href="/admin/opd">
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
                <span class="fw-semibold d-block mb-1">OPD</span>
                <h3 class="card-title mb-2">{{ $opd }}</h3>
              </div>
            </div>
          </a>
          </div>
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <a href="/admin/oprator">
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
                <span class="fw-semibold d-block mb-1">Oprator</span>
                <h3 class="card-title mb-2">{{ $oprator }}</h3>
              </div>
            </div>
          </a>
          </div>
        </div>
      </div>
      <!-- Total Revenue -->
      <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
          <h5 class="card-header">LAPORAN REALTIME PRESENSI <span id="clock" class="badge bg-info">...</span> <button id="tertinggi" class="btn btn-primary btn-sm">TERTINGGI</button>
            <button id="terendah" class="btn btn-danger btn-sm">TERENDAH</button></h5>
          <div class="card-body" id="PresensiCount">
 
          </div>
        </div>
      </div>
      <!--/ Total Revenue -->
      <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
        <div class="row">
          <div class="col-6 mb-4">
            <a href="/admin/pegawai">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img loading="lazy" src="{{ asset('img') }}/icons/icon-fingerprint.png" alt="Credit Card" class="rounded" />
                  </div>
                </div>
                <span class="d-block mb-1">Pegawai</span>
                <h3 class="card-title text-nowrap mb-2">{{ $users }}</h3>
              </div>
            </div>
          </a>
          </div>
          <div class="col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img loading="lazy" src="{{ asset('img') }}/icons/icon-fingerprint.png" alt="Credit Card" class="rounded" />
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Kinerja</span>
                <h3 class="card-title mb-2">#</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('js')
    <script type="text/javascript">
    var page = 1;
    var rank = 'desc';
        $(document).ready(function() {
          loadPresensiCount();
        });

        $('#tertinggi').click(function() {
          rank = 'desc';
          loadPresensiCount();
        });

        $('#terendah').click(function() {
          rank = 'ASC';
          loadPresensiCount();
        });
        async function loadPresensiCount()
        {
          var param = {
            url: '{{ url()->current() }}',
            method: 'GET',
            data: {
              load: 'table',
              rank: rank,
              page: page
            }
          }
          loading(true);
          await transAjax(param).then((result) => {
            loading(false);
            $('#PresensiCount').html(result);
          }).catch((err) => {
            loading(false);
            console.log(err);
          });
        }

        function loading(state)
        {
          if(state) {
            $('#loading').removeClass('d-none');
          } else {
            $('#loading').addClass('d-none');
          }
        }

        function loadPaginate(to) {
          page = to;
          loadLaporan();
        }

        setInterval(() => {
          loadPresensiCount();
        }, 10000);

        jQuery(function($) {
        setInterval(function() {
            var date = new Date(),
                time = date.toLocaleTimeString();
            $("#clock").html(time);
        }, 1000);
    });
    </script>
@endpush