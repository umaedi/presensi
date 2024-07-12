@extends('layouts.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <form id="form">
                @csrf
                    <div class="col-md mb-md-0">
                        <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <span id="notif"></span>
                                <div class="card-body">
                                    <h4>Operator Lama</h4>
                                    <hr>
                                    <div class="form-group mb-2">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="hidden" name="id_operator_lama" value="{{ $user->id }}">
                                        <input name="nama" type="text" id="nama" class="form-control" value="{{ $user->nama }}" />
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="nip" class="form-label">NIP</label>
                                        <input name="nip" type="text" id="nip" class="form-control" value="{{ $user->nip }}" />
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="jabatan" class="form-label">jabatan</label>
                                        <input name="jabatan" type="text" id="jabatan" class="form-control" value="{{ $user->jabatan }}" />
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="organisasi" class="form-label">Organisasi</label>
                                        <input name="organisasi" type="text" id="organisasi" class="form-control" value="{{ $user->opd->nama_opd }}" />
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="unit_organisasi" class="form-label">Unit Organisasi</label>
                                        <input name="unit_organisasi" type="text" id="unit_organisasi" class="form-control" value="{{ $user->unit_organisasi }}"/>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="no_hp" class="form-label">No Tlp/WhatsApp</label>
                                        <input name="no_hp" type="text" id="no_hp" class="form-control" value="{{ $user->no_hp }}"/>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="email" class="form-label">Email</label>
                                        <input name="email" type="text" id="email" class="form-control" value="{{ $user->email }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h4>Operator Baru</h4>
                                    <hr>
                                    <div class="form-group">
                                        <label for="nama_lokasi" class="form-label">Pilih</label>
                                        <select name="id_operator_baru" class="form-control" onchange="changeRole(this.value)">
                                            <option value="">--pilih pegawai--</option>
                                            @foreach ($user_opds as $user_opd)
                                            <option value="{{ $user_opd->id }}">{{ $user_opd->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2" id="userOpd">
                                
                            </div>
                            @include('layouts._button')
                            <button id="btn_submit" type="submit" class="btn btn-primary">Tetapkan role</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/pegawai') }}/js/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('#form').on('submit', async function store(e) {
            e.preventDefault();

            var form = $(this)[0];
            var data = new FormData(form);
            var param = {
                url: '/admin/oprator/set-role',
                method: 'POST',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
            }

            action(true);
            await transAjax(param).then((res) => {
                swal({
                    text: res.message,
                    icon: 'success',
                    timer: 3000,
                }).then(() => {
                    action(false);
                    window.location.href = '/admin/oprator';
                });
            }).catch((err) => {
                action(false);
                swal({
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

        async function changeRole(id)
        {
            var param = {
                url: "{{ url()->current() }}",
                method: 'GET',
                data: {
                    "userId": id,
                }
            }

            await transAjax(param).then((result) => {
                $('#userOpd').html(result);
            });
        }
    </script>
@endpush
