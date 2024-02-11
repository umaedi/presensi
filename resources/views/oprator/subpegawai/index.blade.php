@extends('layouts.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row mb-4">
                <!-- Basic Alerts -->
                <div class="col-md mb-4 mb-md-0">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#opratorModal">Tambah
                        Pegawai Sub OPD</button>
                    <div class="card">
                        <h5 class="card-header">Pegawai Sub OPD</h5>
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
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="opratorModalTitle">Tambah Pegawai</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span id="notif"></span>
                            <div class="row g-2">
                                <div class="col mb-3">

                                    <label for="nameWithTitle" class="form-label">Nama</label>
                                    <select name="id" id="name" class="form-select form-control">
                                        @forelse ($data['users'] as $user)
                                            <option value="{{ $user->id }}">{{ $user->nama }}</option>
                                        @empty
                                            <option value="">Tidak ada data</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Organisasi</label>

                                    <select name="sub_opd_id" id="organisasi" class="form-control form-select">
                                        @forelse ($data['subopds'] as $subopd)
                                            <option value="{{ $subopd->id }}">{{ $subopd->nama_sub_opd }}</option>
                                        @empty
                                            <option value="">Tidak ada data</option>
                                        @endforelse
                                    </select>

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
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css') }}/select2-bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        async function hapusSubPegawai(id, e) {
            e.preventDefault();
            var param = {
                url: '/oprator/sub/pegawai/update/' + id,
                method: 'PUT',
                data: {
                    delete: id
                },
                processData: false,
                contentType: false,
                cache: false,
            };

            action(true);
            try {
                const result = await transAjax(param);
                action(false);
                $('#notif').html(`<div class="alert alert-success">${result.message}</div>`);
                loadTable();
            } catch (err) {
                action(false);
                console.log(err);
                $('#notif').html(`<div class="alert alert-warning">${err.responseJSON.message}</div>`);
            }
        }

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

        $('#storeOprator').on('submit', async function store(e) {
            e.preventDefault();

            var form = $(this)[0];
            var data = new FormData(form);
            var param = {
                url: '/oprator/sub/pegawai/store',
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

            var form = $(this)[0];
            var data = new FormData(form);
            var param = {
                url: '/oprator/importuser',
                method: 'POST',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
            }

            loadingBtn(true, 'btn_submit_import', 'btn_loading_import');
            await transAjax(param).then((result) => {
                loadingBtn(false, 'btn_submit_import', 'btn_loading_import');
                swal({
                    title: 'Berhasil',
                    text: result.message,
                    icon: 'success',
                    timer: 3000,
                });
                $('#importPegawai').modal('hide');
                loadTable();
            }).catch((err) => {
                $('#importPegawai').modal('hide');
                loadingBtn(false, 'btn_submit_import', 'btn_loading_import');
                swal({
                    title: 'Oops!',
                    text: err.responseJSON.message,
                    icon: 'error',
                    timer: 3000,
                });
            });
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
