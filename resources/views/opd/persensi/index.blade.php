@extends('layouts.opd.app')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Riwayat Absensi</h1>
        <div id="clock" class="ml-auto h5 mt-2 font-weight-bold">
            <h6>Loading...</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="date" id="tgl_awal" class="form-control mb-3" placeholder="Tanggal Awal" name="tgl_awal">
                        </div>
                        <div class="col-md-4">
                            <input type="date" id="tgl_akhir" class="form-control mb-3" placeholder="Tanggal Akhir" name="tgl_akhir">
                        </div>
                        <div class="col-md-2 mb-3">
                            <select class="form-control" id="perPage">
                                <option value="10">Perhalaman</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                              </select>
                        </div>
                        <div class="col-md-2">
                            <button onclick="printPage()" class="btn btn-primary">PRINT</button>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.opd._loading')
            <div class="card">
                <div class="table-responsive" id="x-data-table">
                
                </div>
            </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@push('js')
<script type="text/javascript" src="{{ asset('assets/admin') }}/js/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
    var page = 1;
    var paginate = 10;
    var tgl_awal = '';
    var tgl_akhir = '';
        $(document).ready(function() {
            loadData();

            $('#tgl_akhir').change(() => {
                filterTable();
            });

            $('#perPage').change(() => {
                filterTable();
            });
        });

        function filterTable() {
            paginate = $('#perPage').val(); 
            tgl_awal = $('input[name=tgl_awal]').val();
            tgl_akhir = $('input[name=tgl_akhir]').val();
            loadData();
        }

        async function loadData() {
            var param = {
                method: 'GET',
                url: '{{ url()->current() }}',
                data: {
                    load: 'table',
                    page: page,
                    paginate: paginate,
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir,
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

    function loadPaginate(to) {
        page = to
        filterTable()
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

    function printPage()
    {
        var tgl_awal = $('input[name=tgl_awal]').val();
        var tgl_akhir = $('input[name=tgl_akhir]').val();
        var paginate = $('#perPage').val(); 

        window.location.href = "/opd/persensi/print/{{ request('id') }}?tgl_awal="+tgl_awal+"&tgl_akhir="+tgl_akhir
    }

    </script>
@endpush