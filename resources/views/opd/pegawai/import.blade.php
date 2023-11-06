@extends('layouts.opd.app')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Import Data Pegawai</h1>
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
                    <form action="{{ route('opd.pegawai.store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                          <div class="col-md-8">
                            <input type="file" class="form-control" name="file">
                          </div>
                          <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">IMPORT</button>
                          </div>
                          <div class="col-md-2">
                            <a href="{{ asset('assets/pegawai/excel/template-pegawai.xlsx') }}" target="_blank" class="btn btn-primary btn-block">TEMPLATE</a>
                          </div>
                        </div>
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