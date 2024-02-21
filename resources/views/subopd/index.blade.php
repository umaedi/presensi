@extends('layouts.pegawai.app')
@section('content')
    <div id="appCapsule">
        <div class="section my-3">
            <div class="section mt-2">
                <div class="card">
                    <div class="card-body pt-3 pb-3 text-center">
                        <img src="{{ asset('assets/img') }}/vector1.png" alt="image" class="imaged w-50 ">
                        <h2 class="text-center">Silakan pilih titik lokasi tugas dibawah ini</h2>
                    </div>
                </div>
                <div id="dataTable">

                </div>
            </div>
        </div>
    </div>
    @include('layouts.modal._modal_apel')
@endsection
@push('js')
    <script type="text/javascript">
        var page = 1;
        $('#dataTable').html(make_skeleton());
        $(document).ready(function() {
            loadData();
        });

        async function loadData() {
            var param = {
                method: 'GET',
                url: '{{ url()->current() }}',
                data: {
                    load: 'table',
                    page: page,
                }
            }

            await transAjax(param).then(function(result) {
                $('#dataTable').html(result)
            }).catch((err) => {
                console.log('Internal Server Error!');
            });
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
    </script>
@endpush
