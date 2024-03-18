@extends('layouts.main')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold">Pengaturan Akun</h4>
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <h5 class="card-header">Detail Profil</h5>
          <!-- Account -->
          <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
              <img
                src="{{ \Illuminate\Support\Facades\Storage::url($pegawai->photo) }}"
                alt="user-avatar"
                class="d-block rounded"
                height="100"
                width="100"
                id="uploadedAvatar"
              />
            </div>
          </div>
          <hr class="my-0" />
          <div class="card-body">
            <form id="formAccountSettings" onsubmit="return false">
                @method('PUT')
                @csrf
                <div class="row g-2">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Nama</label>
                      <input
                        name="nama"
                        type="text"
                        id="name"
                        class="form-control"
                        value="{{ $pegawai->nama }}"
                      />
                    </div>
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">NIP</label>
                      <input
                        name="nip"
                        type="text"
                        id="nip"
                        class="form-control"
                        value="{{ $pegawai->nip }}"
                      />
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Jabatan</label>
                      <input
                        name="jabatan"
                        type="text"
                        id="jabatan"
                        class="form-control"
                        value="{{ $pegawai->jabatan }}"
                      />
                    </div>
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Organisasi</label>
                      <select class="form-select" name="opd_id" aria-label="Default select example">
                        <option value="{{ $pegawai->opd->id }}">{{ $pegawai->opd->nama_opd }}</option>
                        @foreach ($opds as $opd)
                        <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Unit Organisasi</label>
                      <input
                        name="unit_organisasi"
                        type="text"
                        id="unit_organisasi"
                        class="form-control"
                        value="{{ $pegawai->unit_organisasi }}"
                      />
                    </div>
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">No Tlp/WhatsApp</label>
                      <input
                        name="no_hp"
                        type="text"
                        id="no_hp"
                        class="form-control"
                        value="{{ $pegawai->no_hp }}"
                      />
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input
                        name="email"
                        type="email"
                        id="email"
                        class="form-control"
                        value="{{ $pegawai->email }}"
                      />
                    </div>
                    <div class="col mb-3">
                      <label for="password" class="form-label">Password</label>
                      <input
                        name="password"
                        type="text"
                        id="password"
                        class="form-control"
                        placeholder="Masukan password"
                      />
                    </div>
                  </div>
              <div class="mt-2">
                <button id="btn_loading_update" class="btn_loading btn btn-primary d-none" type="button" disabled>
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Loading...
                </button>
                <button id="btn_update" type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                <a href="/admin/user/destroy/{{ $pegawai->id }}" onclick="return confirm('Yakin hapus pegawai ini')" type="submit" class="btn btn-warning me-2">Hapus Pegawai</a>
              </div>
            </form>
          </div>
          <!-- /Account -->
        </div>
        <span id="notif"></span>
        <form id="formPassword">
        @method('PUT')
        @csrf
        <div class="card">
          <h5 class="card-header">Riwayat Presensi</h5>
          <div class="table-responsive text-nowrap">
            <div class="card-body">
              @include('layouts._loading')
              <div class="table-responsive text-nowrap" id="dataTable">
                      
              </div>
            </div>
          </div>
        </div>
      </form>
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
    <script type="text/javascript">
    var page = 1;
        $(document).ready(function() {
          loadLaporan();
        });

        async function loadLaporan()
        {
          var param = {
            url: '{{ url()->current() }}',
            method: 'GET',
            data: {
              load: 'table',
              page: page
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
        
        $('#formAccountSettings').on('submit', async function(e) {
            e.preventDefault();
            
            var form = $(this)[0];
            var data = new FormData(form);

            var param = {
                url: '/admin/pegawai/update/{{ $pegawai->id }}',
                method: 'POST',
                data: data,
                processData: false,
                contentType: false,
            }
            loading(true, 'btn_update' , 'btn_loading_update');
            await transAjax(param).then((result) => {
              loading(false, 'btn_update', 'btn_loading_update');
              $('#notif').html(`<div class="alert alert-success">${result.message}</div>`);
            }).catch((err) => {
              loading(false, 'btn_update', 'btn_loading_update');
              $('#notif').html(`<div class="alert alert-success">${err.responseJSON.message}</div>`);
            })
        });

        function loading(state, btn, spinner)
        {
          if(state) {
            $('#'+btn).addClass('d-none');
            $('#'+spinner).removeClass('d-none');
          }else {
            $('#'+btn).removeClass('d-none');
            $('#'+spinner).addClass('d-none');
          }
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