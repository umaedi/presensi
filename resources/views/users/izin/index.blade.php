@extends('layouts.pegawai.app')
@section('content')
    <div id="appCapsule">
        <div class="section mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <div class="input-group">
                                        <input id="tanggalAwal" type="text" class="form-control datepicker start_date"
                                            name="tanggal_awal" placeholder="Tanggal Awal" readonly>
                                        <div class="input-group-addon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon-sm"
                                                viewBox="0 0 512 512">
                                                <rect fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="32" x="48" y="80" width="416" height="384"
                                                    rx="48" />
                                                <circle fill="currentColor" cx="296" cy="232" r="24" />
                                                <circle fill="currentColor" cx="376" cy="232" r="24" />
                                                <circle fill="currentColor" cx="296" cy="312" r="24" />
                                                <circle fill="currentColor" cx="376" cy="312" r="24" />
                                                <circle fill="currentColor" cx="136" cy="312" r="24" />
                                                <circle fill="currentColor" cx="216" cy="312" r="24" />
                                                <circle fill="currentColor" cx="136" cy="392" r="24" />
                                                <circle fill="currentColor" cx="216" cy="392" r="24" />
                                                <circle fill="currentColor" cx="296" cy="392" r="24" />
                                                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="32" stroke-linecap="round" d="M128 48v32M384 48v32" />
                                                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="32" d="M464 160H48" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4  col-md-4">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <div class="input-group">
                                        <input id="tanggalAkhir" type="text" name="tanggal_akhir"
                                            placeholder="Tanggal Akhir" class="form-control datepicker end_date" readonly>
                                        <div class="input-group-addon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon-sm"
                                                viewBox="0 0 512 512">
                                                <rect fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="32" x="48" y="80" width="416" height="384"
                                                    rx="48" />
                                                <circle fill="currentColor" cx="296" cy="232" r="24" />
                                                <circle fill="currentColor" cx="376" cy="232" r="24" />
                                                <circle fill="currentColor" cx="296" cy="312" r="24" />
                                                <circle fill="currentColor" cx="376" cy="312" r="24" />
                                                <circle fill="currentColor" cx="136" cy="312" r="24" />
                                                <circle fill="currentColor" cx="216" cy="312" r="24" />
                                                <circle fill="currentColor" cx="136" cy="392" r="24" />
                                                <circle fill="currentColor" cx="216" cy="392" r="24" />
                                                <circle fill="currentColor" cx="296" cy="392" r="24" />
                                                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="32" stroke-linecap="round" d="M128 48v32M384 48v32" />
                                                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="32" d="M464 160H48" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 justify-content-between">
                            <button id="tampilkan" type="button" class="btn btn-primary mt-1 btn-sortir">
                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon-xs" viewBox="0 0 512 512">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="32" d="M416 128L192 384l-96-96" />
                                </svg>
                                Tampilkan</button>
                            <button id="printPage" class="btn btn-warning mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon-xs" viewBox="0 0 512 512">
                                    <path
                                        d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24"
                                        fill="none" stroke="currentColor" stroke-linejoin="round"
                                        stroke-width="32" />
                                    <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32"
                                        fill="none" stroke="currentColor" stroke-linejoin="round"
                                        stroke-width="32" />
                                    <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24"
                                        fill="none" stroke="currentColor" stroke-linejoin="round"
                                        stroke-width="32" />
                                    <circle cx="392" cy="184" r="24" />
                                </svg>
                                Cetak</button>
                            <button type="button" data-toggle="modal" data-target="#modal-add"
                                class="btn btn-success mt-1 btn-clear"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" class="bi bi-plus-lg"
                                    viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                </svg> Tambah Cuti</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section my-3">
            <div class="section-title">Data Izin</div>
            <div class="cuti" id="dataTable">

            </div>
        </div>
        <div class="modal fade modalbox" id="modal-add" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Permohonan</h5><a href="javascript:;"
                            data-dismiss="modal">Close</a>
                    </div>
                    <div class="modal-body">
                        <form id="tambahIzin" autocomplete="off">
                            @csrf
                            <div class="form-group rounded">
                                <div class="input-wrapper">
                                    <label class="label">Nama</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->nama }}"
                                        readonly=""><i class="clear-input"><ion-icon name="close-circle"
                                            role="img" class="md hydrated" aria-label="close circle"></ion-icon></i>
                                </div>
                            </div>
                            <div class="form-group rounded">
                                <div class="input-wrapper">
                                    <label class="label">Mulai Cuti</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="cutystart"
                                            name="tanggal_awal" placeholder="Pilih" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group rounded">
                                <div class="input-wrapper">
                                    <label class="label">Berakhir Cuti</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="cutyend"
                                            name="tanggal_akhir" placeholder="Pilh" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group rounded">
                                <div class="input-wrapper">
                                    <label class="label">Tanggal Masuk Kerja</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="tanggal_masuk"
                                            placeholder="Pilih" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group rounded">
                                <div class="input-wrapper">
                                    <label class="label">Jumlah Cuti</label>
                                    <input type="number" class="form-control" name="jumlah_izin" value=""><i
                                        class="clear-input"><ion-icon name="close-circle" role="img"
                                            class="md hydrated" aria-label="close circle"></ion-icon></i>
                                </div>
                            </div>
                            <div class="form-group rounded">
                                <div class="input-wrapper">
                                    <label class="label">Keterangan</label>
                                    <textarea rows="2" class="form-control cuty_description" name="keterangan"></textarea><i class="clear-input"><ion-icon name="close-circle"
                                            role="img" class="md hydrated" aria-label="close circle"></ion-icon></i>
                                </div>
                            </div>
                            <div class="form-group rounded">
                                <div class="input-wrapper">
                                    <label class="label">Lampiran</label>
                                    <input type="file" class="form-control cuty_description"
                                        name="lampiran"></input><i class="clear-input"><ion-icon name="close-circle"
                                            role="img" class="md hydrated" aria-label="close circle"></ion-icon></i>
                                </div>
                            </div>
                            <div class="form-group rounded">
                                @include('layouts.pegawai._loading_submit')
                                <button id="btnSubmit" type="submit"
                                    class="btn btn-primary btn-lg btn-block mt-2">KIRIM</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modalbox" id="modal-show" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Permohonan Cuti</h5>
                        <a href="javascript:;" data-dismiss="modal">Close</a>
                    </div>
                    <div class="modal-body rounded">
                        <form id="form-update-cuty" autocomplete="off">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <label class="label">Nama</label>
                                    <input type="hidden" name="id" id="cuty-id">
                                    <input type="text" class="form-control" id="name"
                                        value="{{ auth()->user()->nama }}"><i class="clear-input"><ion-icon
                                            name="close-circle" role="img" class="md hydrated"
                                            aria-label="close circle"></ion-icon></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <label class="label">Mulai Cuti</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="awal-cuty" name="tanggal_awal"
                                            value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <label class="label">Berakhir Cuti</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="akhir-cuty" name="tanggal_akhir"
                                            value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <label class="label">Tanggal Masuk Kerja</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="tanggal-masuk"
                                            name="tanggal_masuk" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <label class="label">Jumlah Cuti</label>
                                    <input type="number" class="form-control" name="jumlah_izin" id="jumlah-cuty"
                                        value=""><i class="clear-input"><ion-icon name="close-circle"
                                            role="img" class="md hydrated" aria-label="close circle"></ion-icon></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <label class="label">Keterangan</label>
                                    <textarea rows="2" class="form-control cuty_description" id="keterangan-cuty" name="keterangan"></textarea><i class="clear-input"><ion-icon name="close-circle"
                                            role="img" class="md hydrated" aria-label="close circle"></ion-icon></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <label class="label">Keterangan</label>
                                    <textarea rows="2" class="form-control cuty_description" id="keterangan-cuty" name="keterangan"></textarea><i class="clear-input"><ion-icon name="close-circle"
                                            role="img" class="md hydrated" aria-label="close circle"></ion-icon></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <label class="label">Lampiran</label>
                                    <input type="file" class="form-control cuty_description" name="lampiran">
                                    <a id="lampiran" href="">Lampiran yang sudah di upload lihat disini</a>
                                </div>
                            </div>
                            <div class="form-group">
                                @include('layouts.pegawai._loading_update')
                                <button id="btnUpdate" type="submit"
                                    class="btn btn-primary btn-lg btn-block mt-2">SIMPAN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.modal._modal')
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        var page = 1;
        var tanggalAwal = '';
        var tanggalAkhir = '';

        $('#dataTable').html(make_skeleton());
        $(document).ready(function() {
            loadTable();

            $('#tampilkan').click(function() {
                filterTable();
            });

            $('#tanggal_awal').change(function() {
                filterTable();
            });

            $('#tanggal_akhir').change(function() {
                filterTable();
            });

            $('#printPage').click(function() {
                printPage();
            });

            $('#tambahIzin').submit(async function(e) {
                e.preventDefault();
                loadingsubmit(true);

                var data = new FormData(this);
                var param = {
                    url: '/user/izin/store',
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false
                }

                await transAjax(param).then((res) => {
                    swal({
                        text: res.message,
                        icon: 'success',
                        timer: 3000,
                    }).then(() => {
                        loadingsubmit(false);
                        window.location.href = '/user/izin';
                    });
                }).catch((err) => {
                    loadingsubmit(false);
                    swal({
                        text: err.responseJSON.message,
                        icon: 'error',
                        timer: 3000,
                    }).then(() => {});
                });

                function loadingsubmit(state) {
                    if (state) {
                        $('#btnSubmit').addClass('d-none');
                        $('#loadingSubmit').removeClass('d-none');
                    } else {
                        $('#btnSubmit').removeClass('d-none');
                        $('#loadingSubmit').addClass('d-none');
                    }
                }
            });

            $('#form-update-cuty').submit(async function(e) {
                e.preventDefault();
                loadingsubmit(true);
                var param = {
                    url: '/user/izin/update',
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                }

                await transAjax(param).then((res) => {
                    swal({
                        text: res.message,
                        icon: 'success',
                        timer: 3000,
                    }).then(() => {
                        loadingsubmit(false);
                        window.location.href = '/user/izin';
                    });
                }).catch((err) => {
                    loadingsubmit(false);
                    swal({
                        text: err.responseJSON.message,
                        icon: 'error',
                        timer: 3000,
                    }).then(() => {});
                });

                function loadingsubmit(state) {
                    if (state) {
                        $('#btnUpdate').addClass('d-none');
                        $('#loadingUpdate').removeClass('d-none');
                    } else {
                        $('#btnUpdate').removeClass('d-none');
                        $('#loadingUpdate').addClass('d-none');
                    }
                }
            });
        });

        function getCuty(data) {
            $('#cuty-id').val(data.id);
            $('#awal-cuty').val(data.tanggal_awal);
            $('#akhir-cuty').val(data.tanggal_akhir);
            $('#tanggal-masuk').val(data.tanggal_masuk);
            $('#jumlah-cuty').val(data.jumlah_izin);
            $('#keterangan-cuty').val(data.keterangan);
            $('#lampiran').attr('href', "{{ asset('storage/lampiran') }}/" + data.lampiran);
        }

        function filterTable() {
            tanggalAwal = $('#tanggalAwal').val();
            tanggalAkhir = $('#tanggalAkhir').val();
            loadTable();
        }

        async function loadTable() {
            var param = {
                method: 'GET',
                url: '{{ url()->current() }}',
                data: {
                    load: 'table',
                    page: page,
                    tanggal_awal: tanggalAwal,
                    tanggal_akhir: tanggalAkhir,
                }
            }

            loading(true)
            await transAjax(param).then((result) => {
                loading(false)
                $('#dataTable').html(result);
            }).catch((err) => {
                loading(false)
                console.log('err');
            });

            function loading(state) {
                if (state) {
                    $('#loading').removeClass('d-none');
                } else {
                    $('#loading').addClass('d-none');
                }
            }
        }

        function make_skeleton() {
            var output = '';
            for (var count = 0; count < 3; count++) {
                output += '<div class="col-12">';
                output += '<div class="ph-item">';
                output += '<div class="ph-picture"></div>';
                output += '</div>';
                output += '</div>';
            }
            return output;
        }

        function loadPaginate(to) {
            page = to
            filterTable()
        }

        function printPage() {
            var tanggalAwal = $('#tanggalAwal').val();
            var tanggalAkhir = $('#tanggalAkhir').val();
            window.location.href = "/user/izin/print?tanggal_awal=" + tanggalAwal + "&tanggal_akhir=" + tanggalAkhir;
        }

        $('#awal-cuty').click(function() {
            $('#awal-cuty').attr('type', 'date');
        });
        $('#akhir-cuty').click(function() {
            $('#akhir-cuty').attr('type', 'date');
        });
        $('#tanggal-masuk').click(function() {
            $('#tanggal-masuk').attr('type', 'date');
        });
    </script>
@endpush
