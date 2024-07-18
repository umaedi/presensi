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
                src="{{ asset('storage/users/img/face'.$pegawai->photo)}}"
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
                    <div class="col-12 col-md-6">
                      <label for="nameWithTitle" class="form-label">Nama</label>
                      <input
                        name="nama"
                        type="text"
                        id="name"
                        class="form-control"
                        value="{{ $pegawai->nama }}"
                      />
                    </div>
                    <div class="col-12 col-md-6">
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
                  <div class="row g-2 mt-1">
                    <div class="col-12 col-md-6">
                      <label for="nameWithTitle" class="form-label">Jabatan</label>
                      <input
                        name="jabatan"
                        type="text"
                        id="jabatan"
                        class="form-control"
                        value="{{ $pegawai->jabatan }}"
                      />
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="nameWithTitle" class="form-label">Organisasi</label>
                      <input
                        name="opd_id"
                        type="text"
                        id="organisasi"
                        class="form-control"
                        value="{{ $pegawai->opd->nama_opd }}"
                        readonly
                      />
                    </div>
                  </div>
                  <div class="row g-2 mt-1">
                    <div class="col-12 col-md-6">
                      <label for="nameWithTitle" class="form-label">Unit Organisasi</label>
                      <input
                        name="unit_organisasi"
                        type="text"
                        id="unit_organisasi"
                        class="form-control"
                        value="{{ $pegawai->unit_organisasi }}"
                      />
                    </div>
                    <div class="col-12 col-md-6">
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
                  <div class="row g-2 mt-1">
                    <div class="col-12 col-md-6">
                      <label for="email" class="form-label">Email</label>
                      <input
                        name="email"
                        type="email"
                        id="email"
                        class="form-control"
                        value="{{ $pegawai->email }}"
                      />
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="password" class="form-label">Password</label>
                      <input
                        name="password"
                        type="text"
                        id="password"
                        class="form-control"
                        placeholder="Masukan password"
                      />
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                      <label for="status_pegawai" class="form-label">Status Pegawai</label>
                      <select class="form-select" name="tpp" aria-label="status">
                        <option value="">pilih</option>
                        @foreach ($status as $st)
                        <option value="{{ $st->id }}" {{ $st->id == $pegawai->status_pegawai ? 'selected' : '' }}>{{ $st->status }}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                      <label for="nominal" class="form-label">Tambahan Penghasilan Pegawai (TPP)</label>
                      <div class="input-group mb-2">
                        <input type="text" name="tpp" value="{{ formatRp($pegawai->tpp) }}" class="form-control" id="nominal" placeholder="Masukan nominal" onkeyup="formatRupiah(this)">
                      </div>
                    </div>
                  </div>
              <div class="mt-2">
                <button id="btn_loading_update" class="btn_loading btn btn-primary d-none" type="button" disabled>
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Loading...
                </button>
                <button id="btn_update" type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
              </div>
            </form>
          </div>
          <!-- /Account -->
        </div>
        <div id="notif" class="card mb-3 bg-primary d-none">
          <div class="card-body">
              <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                  </symbol>
                  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                  </symbol>
                  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                  </symbol>
              </svg>
              <div class="d-flex align-items-center" role="alert">
                  <svg class="bi flex-shrink-0 me-2" style="color: #fff" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                  <div>
                  <span id="message" style="color: #fff">-</span>
                  </div>
              </div>
          </div>
      </div>

        <div class="card mb-3">
          <h5 class="card-header">Report Presensi Pegawai</h5>
          <div class="card-body">
              <div class="row text-center g-2">
                  <div class="col-12 col-md-3">
                      <input id="tanggalAwal" type="text" class="form-control datepicker start_date"
                          name="tanggal_awal" placeholder="Tanggal Awal">
                  </div>
                  <div class="col-12 col-md-3">
                      <input id="tanggalAkhir" type="text" name="tanggal_akhir" placeholder="Tanggal Akhir"
                          class="form-control datepicker end_date">
                  </div>
                  <div class="col-12 col-md-2">
                      <select id="status" class="form-select" aria-label="Default select example">
                          <option value="">Status Presensi</option>
                          <option value="Tepat waktu">Tepat Waktu</option>
                          <option value="Terlambat">Terlambat</option>
                          {{-- <option value="Tidak Masuk">Tidak Masuk</option> --}}
                          <option value="Apel">Apel</option>
                          <option value="DL">DL</option>
                      </select>
                  </div>
                  <div class="col-12 col-md-2">
                      <button id="tampilkan" class="form-control btn-primary">TAMPILKAN</button>
                  </div>
                  <div class="col-12 col-md-2">
                      <button id="export" class="form-control btn-primary">EXPORT</button>
                  </div>
              </div>
          </div>
      </div>
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
      </div>
    </div>
  </div>
@endsection
@push('js')
<script type="text/javascript" src="{{ asset('assets/pegawai') }}/js/plugins/datepicker/bootstrap-datepicker.js">
</script>
    <script type="text/javascript">
        var tanggalAwal = '';
        var tanggalAkhir = '';
        var status_pegawai = '';
        var status = '';
        var page = 1;
        $(document).ready(function() {
          loadTable();
        });

        $('#tampilkan').click(function() {
                filterTable();
        });

        function filterTable() {
            tanggalAwal = $('#tanggalAwal').val();
            tanggalAkhir = $('#tanggalAkhir').val();
            status_pegawai = $('#statusPegawai').val();
            status = $('#status').val();
            loadTable();
        }

        async function loadTable()
        {
          var param = {
            url: '{{ url()->current() }}',
            method: 'GET',
            data: {
              load: 'table',
              tanggal_awal: tanggalAwal,
              tanggal_akhir: tanggalAkhir,
              status_pegawai: status_pegawai,
              status: status,
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
                url: '/oprator/pegawai/update/{{ $pegawai->id }}',
                method: 'POST',
                data: data,
                processData: false,
                contentType: false,
            }
            loading(true, 'btn_update' , 'btn_loading_update');
            await transAjax(param).then((result) => {
              loading(false, 'btn_update', 'btn_loading_update');
              $('#message').html(result.message);
              $('#notif').removeClass('d-none');
            }).catch((err) => {
              loading(false, 'btn_update', 'btn_loading_update');
              $('#notif').html(`<div class="alert alert-success">${err.responseJSON.message}</div>`);
            })
        });

        $('#formPassword').on('submit', async function(e) {
            e.preventDefault();
            
            var form = $(this)[0];
            var data = new FormData(form);

            var param = {
                url: '/admin/profile/update/password',
                method: 'POST',
                data: data,
                processData: false,
                contentType: false,
            }
            loading(true, 'btn_deactivation', 'btn_loading_account');
            await transAjax(param).then((result) => {
              loading(false, 'btn_deactivation','btn_loading_account');
              $('#notif').html(`<div class="alert alert-success">${result.data}</div>`);
            }).catch((err) => {
              loading(false, 'btn_deactivation', 'btn_loading_account');
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

        const rupiah = (number) => {
        const formattedNumber = new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR",
        }).format(number);
          return formattedNumber.split(",")[0]; // Mengambil bagian pertama sebelum tanda koma
        };

        function formatRupiah(input)
        {
          const value = input.value.replace(/\D/g, "");
          input.value = rupiah(value);
        }


        $(".datepicker").datepicker({
            format: "dd-mm-yyyy",
            "autoclose": true
        });

        $('#export').click(function() {
            var user_id = "{{ $pegawai->id }}"
            var tanggalAwal = $('#tanggalAwal').val();
            var tanggalAkhir = $('#tanggalAkhir').val();
            var status_pegawai = $('#statusPegawai').val();
            var status = $('#status').val();
            window.location.href = '/oprator/presensi/pegawai/export?user_id=' + user_id + '&tanggal_awal=' + tanggalAwal + '&tanggal_akhir=' +
                tanggalAkhir + '&status_pegawai='+status_pegawai + '&status=' + status;
        });
    </script>
@endpush