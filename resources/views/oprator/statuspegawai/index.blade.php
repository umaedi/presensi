@extends('layouts.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row mb-4">
                <!-- Basic Alerts -->
                <div class="col-md mb-4 mb-md-0">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#statusModal">Tambah Status
                        Pegawai</button>
                    <div class="card">
                        <h5 class="card-header">Status Pegawai</h5>
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
       
    </div>
     <!-- Modal -->
     <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <form id="storeStatus">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalTitle">Tambah Status Pegawai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="notif"></span>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <label for="status" class="form-label">Masukan status pegawai</label>
                                <input name="status" type="text" id="status" class="form-control" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Tutup
                            </button>
                            <button id="btn_loading" class="btn_loading btn btn-primary d-none" type="button"
                                disabled>
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button id="btn_submit" type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="content-backdrop fade"></div>
@endsection
@push('js')
    <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        var search = '';
        var page = 1;
        $(document).ready(function() {
            loadTable();

            $('#search').on('keypress', function(e) {
                if (e.which == 13) {
                    filterTable();
                    return false;
                }
            });
        });

        function filterTable() {
            search = $('#search').val();
            loadTable();
        }

        async function loadTable() {
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

        function loadPaginate(to) {
            page = to
            filterTable()
        }

        $('#storeStatus').on('submit', async function store(e) {
            e.preventDefault();

            var form = $(this)[0];
            var data = new FormData(form);
            var param = {
                url: '/oprator/statuspegawai/store',
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

        function action(state) {
            if (state) {
                $('#btn_loading').removeClass('d-none');
                $('#btn_submit').addClass('d-none');
            } else {
                $('#btn_loading').addClass('d-none');
                $('#btn_submit').removeClass('d-none');
            }
        }
    </script>
@endpush
