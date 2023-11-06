@extends('layouts.opd.app')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Dashboard</h1>
        <div id="clock" class="ml-auto h5 mt-2 font-weight-bold">
            <h6>Loading...</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
          <a href="" style="text-decoration: none">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Kapala OPD</h4>
              </div>
              <div class="card-body">
                {{ auth()->guard('opd')->user()->name }}
              </div>
            </div>
          </div>
        </a>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
          <a href="./pegawai" style="text-decoration: none">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="far fa-user"></i>
              </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Data Pegawai</h4>
              </div>
              <div class="card-body">
                {{ $pegawai }}
              </div>
            </div>
          </div>
        </a>
        </div>

      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4>Absensi Harian. {{ $tanggal }}</h4>
              <div class="notif">
                <button type="button" class="btn btn-primary">
                    Hadir <span class="badge badge-transparent">{{ $hadir }}</span>
                </button>
                <button type="button" class="btn btn-danger">
                    Terlambat <span class="badge badge-transparent">{{ $terlambat }}</span>
                </button>
                <button type="button" class="btn btn-warning">
                    Izin <span class="badge badge-transparent">{{ $izin }}</span>
                </button>
            </div>
            </div>
            @include('layouts.opd._loading')
            <div class="card">
                <div class="table-responsive" id="x-data-table">
                
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            loadData();

        });

        async function loadData() {
            var param = {
                method: 'GET',
                url: '{{ url()->current() }}',
                data: {
                    load: 'table',
                }
            }
            loading(true);
            await transAjax(param).then((result) => {
                loading(false);
                $('#x-data-table').html(result)

            }).catch((err) => {
              loading(false);
              console.log('error');
        });
    }

    jQuery(function($) {
        setInterval(function() {
            var date = new Date(),
                time = date.toLocaleTimeString();
            $("#clock").html(time);
        }, 1000);
    });

    function loading(state) {
        if(state) {
            $('#loading').removeClass('d-none');
        } else {
            $('#loading').addClass('d-none');
        }
    }

    // setInterval(() => {
    //   loadData();
    // }, 3000);

    </script>
@endpush