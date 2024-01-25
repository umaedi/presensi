@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-4">
            <div class="col-md mb-4 mb-md-0">
              <div class="card">
                  <div class="card-body">
                        <div class="row text-center">
                          <div class="col col-md-2">
                            <input id="tanggalAwal" type="text" class="form-control datepicker start_date" name="tanggal_awal" placeholder="Tanggal Awal">
                          </div>
                          <div class="col col-md-2">
                            <input id="tanggalAkhir" type="text" name="tanggal_akhir" placeholder="Tanggal Akhir" class="form-control datepicker end_date">
                          </div>
                          <div class="col col-md-3">
                            <select id="status" class="form-select" aria-label="Default select example">
                                <option value="">Status</option>
                                <option value="DL">DL</option>
                                <option value="Apel">Apel</option>
                                <option value="Terlambat">Terlambat</option>
                              </select>
                          </div>
                          <div class="col">
                            <button id="tampilkan" class="form-control btn-primary">TAMPILKAN</button>
                          </div>
                          <div class="col">
                            <button id="export" class="form-control btn-primary">EXPORT</button>
                          </div>
                        </div>
                </div>
              </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md mb-4 mb-md-0">
              <div class="card">
                  <h5 class="card-header">Master Presensi</h5>
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
<script type="text/javascript" src="{{ asset('assets/pegawai') }}/js/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script>
        var search = '';
        var tanggalAwal = '';
        var tanggalAkhir = '';
        var status = '';
        var page = 1;
        $(document).ready(function() {
            loadTable();

            $('#search').on('keypress', function(e) {
                if(e.which == 13) {
                    filterTable();
                    return false;
                }
            });

            $('#tampilkan').click(function() {
                filterTable();
            });

            $('#tanggal_awal').change(function() {
                filterTable();
            });

            $('#tanggal_akhir').change(function() {
                filterTable();
            });
        });

        function filterTable() {
            search = $('#search').val();
            tanggalAwal = $('#tanggalAwal').val();
            tanggalAkhir =  $('#tanggalAkhir').val();
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
                    search: search,
                    tanggal_awal: tanggalAwal,
                    tanggal_akhir: tanggalAkhir,
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
            })
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
        });

        $('#import').on('submit', async function store(e) {
          e.preventDefault();

          var form 	= $(this)[0]; 
          var data 	= new FormData(form);
          var param = {
              url: '/oprator/importuser',
              method: 'POST',
              data: data,
              processData: false,
              contentType: false,
              cache: false,
          }

          loadingBtn(true,'btn_submit_import', 'btn_loading_import');
          await transAjax(param).then((result) => {
            loadingBtn(false,'btn_submit_import', 'btn_loading_import');
            swal({ title: 'Berhasil', text: result.message, icon: 'success', timer: 3000, });
            $('#importPegawai').modal('hide');
            loadTable();
          }).catch((err) => {
            $('#importPegawai').modal('hide');
            loadingBtn(false,'btn_submit_import', 'btn_loading_import');
            swal({ title: 'Oops!', text: err.responseJSON.message, icon: 'error', timer: 3000, });
          });
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

        $(".datepicker").datepicker({
            format: "dd-mm-yyyy",
            "autoclose": true
        });

        $('#export').click(function() {
            tanggalAwal = $('#tanggalAwal').val();
            tanggalAkhir =  $('#tanggalAkhir').val();
            status = $('#status').val();

            window.location.href = '/oprator/presensi/export?tanggal_awal='+tanggalAwal+'&tanggal_akhir='+tanggalAkhir+'&status='+status;
        });
    </script>
@endpush

