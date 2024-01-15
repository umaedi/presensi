@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-4">
            <!-- Basic Alerts -->
            <div class="col-md mb-4 mb-md-0">
                <a href="/admin/opd/create" class="btn btn-primary mb-3">Tambah OPD</a>
              <div class="card">
                  <h5 class="card-header">Data OPD</h5>
                  <div class="card-body">
                    @include('layouts._loading')
                    <div class="table-responsive text-nowrap" id="dataTable">
                        
                    </div>
                </div>
              </div>
            </div>
            <!--/ Basic Alerts -->
          </div>
      </div>
         <!-- Modal -->
    <div class="modal fade" id="opratorModal" tabindex="-1" aria-hidden="true">
        <form id="storeOprator">
          @csrf
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="opratorModalTitle">Tambah OPD</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
            <span id="notif"></span>
            <div class="row g-2">
              <div class="col mb-3">
                <label for="nameWithTitle" class="form-label">Nama</label>
                <input
                  name="nama"
                  type="text"
                  id="name"
                  class="form-control"
                  placeholder="Masukan nama lengkap"
                />
              </div>
              <div class="col mb-3">
                <label for="nameWithTitle" class="form-label">NIP</label>
                <input
                  name="nip"
                  type="text"
                  id="nip"
                  class="form-control"
                  placeholder="Masukan NIP"
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
                  placeholder="Masukan Jabatan"
                />
              </div>
              <div class="col mb-3">
                <label for="nameWithTitle" class="form-label">Organisasi</label>
                <input
                  name="organisasi"
                  type="text"
                  id="organisasi"
                  class="form-control"
                  placeholder="Masukan organisasi"
                />
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
                  placeholder="Masukan unit organisasi"
                />
              </div>
              <div class="col mb-3">
                <label for="nameWithTitle" class="form-label">No Tlp/WhatsApp</label>
                <input
                  name="no_hp"
                  type="text"
                  id="no_hp"
                  class="form-control"
                  placeholder="Masukan no tlp"
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
                  placeholder="Masukan email"
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
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                  Tutup
                </button>
                @include('layouts._button')
                <button id="btn_submit" type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    <div class="content-backdrop fade"></div>
  </div>
@endsection
@push('js')
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

        $('#storeOprator').on('submit', async function store(e) {
          e.preventDefault();

          var form 	= $(this)[0]; 
          var data 	= new FormData(form);
          var param = {
            url: '/oprator/pegawai/store',
            method: 'POST',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
          }

          action(true);
          await transAjax(param).then((result) => {
            action(false);
            $('#notif').html(`<div class="alert alert-success">${result.message}</div>`);
            loadTable();
          }).catch((err) => {
            action(false);
            console.log(err);
            $('#notif').html(`<div class="alert alert-warning">${err.responseJSON.message}</div>`);
          });
        });

        $('#name').on('click', function() {
          $('#notif').html('');
          $('input').val('');
        });

        function action(state)
        {
            if(state) {
                $('#btn_loading').removeClass('d-none');
                $('#btn_submit').addClass('d-none');
            } else {
                $('#btn_loading').addClass('d-none');
                $('#btn_submit').removeClass('d-none');
            }
        }
    </script>
@endpush

