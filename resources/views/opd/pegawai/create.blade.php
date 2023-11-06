@extends('layouts.opd.app')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Tambah Pegawai</h1>
        <div id="clock" class="ml-auto h5 mt-2 font-weight-bold">
            <h6>Loading...</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
                @if($feedback = session('feedback'))
                @include('layouts.opd._alert_feedback', ['feedback' => $feedback])
                @endif
                <div class="card-body">
                    <form action="{{ route('opd.pegawai.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                          <label for="nip">NIP</label>
                          <input type="number" class="form-control" id="nip" name="nip" required>
                        </div>
                        <div class="form-group">
                          <label for="name">Nama Lengkap</label>
                          <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                          <label for="jabatan">Jabatan</label>
                          <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                        </div>
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                          <label for="no_tlp">No Telp</label>
                          <input type="number" class="form-control" id="no_tlp" name="no_tlp" required>
                        </div>
                        <div class="form-group">
                          <label for="password">Password</label>
                          <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                          <label for="opd">OPD ID: <span class="opd_id"></span></label>
                          <select class="form-control" id="x-opd" name="opd_id" required>
                            <option value="">--PILIH OPD--</option>
                            @forelse ($opds as $opd)
                            <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                            @empty
                            <option>Belum ada data</option>
                            @endforelse
                          </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </form>
                </div>
            </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#x-opd').change(() => {
                let opd_id = $('select[name=opd]').val();
                document.querySelector('.opd_id').innerHTML = opd_id;
            });

            jQuery(function($) {
                setInterval(function() {
                    var date = new Date(),
                        time = date.toLocaleTimeString();
                    $("#clock").html(time);
                }, 1000);
            });
        });
    </script>
@endpush