@extends('layouts.opd.app')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Data Pegawai</h1>
        <div id="clock" class="ml-auto h5 mt-2 font-weight-bold">
            <h6>Loading...</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card mb-3">
                @if($feedback = session('feedback'))
                @include('layouts.opd._alert_feedback', ['feedback' => $feedback])
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" id="search" class="form-control" placeholder="Cari Pegawai..." name="q">
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" id="perPage">
                                <option value="10">Perhalaman</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                              </select>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('opd.pegawai.create') }}" class="btn btn-primary btn-block">TAMBAH PEGAWAI</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('opd.pegawai.import') }}" class="btn btn-primary btn-block">IMPORT</a>
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
    <script type="text/javascript">
    var page = 1;
    var paginate = 10;
    var search = '';
        $(document).ready(function() {
            loadData();

            $('#search').on('keypress', function (e) {
                if (e.which == 13) {
                    filterTable()
                    return false;
                }
            });

            $('#perPage').change(() => {
                filterTable();
            });

        });

        function filterTable() {
            paginate = $('#perPage').val(); 
            search = $('input[name=q]').val();
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
                    search: search,
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

    </script>
@endpush