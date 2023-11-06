@extends('layouts.opd.app')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
          <div class="breadcrumb-item">Profile</div>
        </div>
      </div>
      <div class="section-body">
        <div class="row mt-sm-4">
          <div class="col-12 col-md-12 col-lg-5">
            <div class="card profile-widget">
              <div class="profile-widget-header">
                <img alt="image" src="{{ asset('storage/pegawai/img/profile/'.$pegawai->image ?? ) }}" class="rounded-circle profile-widget-picture">
                <div class="profile-widget-items">
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Masuk</div>
                    <div class="profile-widget-item-value">{{ $hadir }}</div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Telat</div>
                    <div class="profile-widget-item-value">{{ $telat }}</div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Izin</div>
                    <div class="profile-widget-item-value">{{ $izin }}</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
                  <div class="card-header">
                    <h4>Data Diri {{ $pegawai->name }}</h4>
                  </div>
                  @if($feedback = session('feedback'))
                  @include('layouts.opd._alert_feedback', ['feedback' => $feedback])
                  @endif
                  <div class="card-body">
                      <form action="./update/{{ $pegawai->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="number" class="form-control" id="nip" value="{{ $pegawai->nip }}" name="nip">
                            </div>
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" value="{{ $pegawai->name }}" name="name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ $pegawai->email }}" name="email">
                            </div>
                            <div class="form-group">
                                <label for="no_tlp">No Tlp</label>
                                <input type="number" class="form-control" id="no_tlp" value="{{ $pegawai->no_tlp }}" name="no_tlp">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                      </form>
                  </div>
              </div>
          </div>
          <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
                <div class="card-header">
                  <h4>Absensi 1 Minggu Terakhir</h4>
                </div>
                @include('layouts.opd._loading')
                <div class="card-body" id="x-data-table">
                  
                </div>
                <div class="card-footer text-right">
                  <a href="./persensi/{{ request('id') }}" class="btn btn-primary">Lihat Semua</a>
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

        function filterTable() {
            loadData();
        }

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

        function loading(state) {
            if(state) {
                $('#loading').removeClass('d-none');
            } else {
                $('#loading').addClass('d-none');
            }
        }

        jQuery(function($) {
            setInterval(function() {
                var date = new Date(),
                    time = date.toLocaleTimeString();
                $("#clock").html(time);
            }, 1000);
        });
    }
    </script>
@endpush