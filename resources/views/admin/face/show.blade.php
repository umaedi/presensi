@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-4">
            <!-- Basic Alerts -->
            <div class="col-md mb-4 mb-md-0">
                <span id="notif"></span>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_opd" class="form-label">Nama Pegawai</label>
                                <input
                                name="nama_opd"
                                type="text"
                                id="nama_opd"
                                class="form-control"
                                value="{{ $user->user->nama }}"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lat" class="form-label">Nama OPD</label>
                                <input
                                name="lat"
                                type="text"
                                id="lat"
                                class="form-control"
                                value="{{ $user->user->opd->nama_opd }}"
                                />
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <p>PHOTO WAJAH TERDAFTAR</p>
                            <img src="{{ asset('storage/users/img/face'. $user->user->photo) }}" width="100%" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <p>PHOTO WAJAH SAAT PRESENSI</p>
                            <img src="{{ asset($user->face) }}" width="100%" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" value="{{ $user->log_type }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection