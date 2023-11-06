@extends('layouts.pegawai.print')
@section('content')
<div class="card">
    <div class="card">
        <div class="table-responsive" id="x-data-table">
            
        </div>
    </div>
</div>
@endsection
@push('js')
    <script type="text/javascript">
    var tgl_awal = '{{ request('tanggal_awal') }}';
    var tgl_akhir = '{{ request('tanggal_akhir') }}';

    $(document).ready(function() {
        loadData();

    });

    var url = '{{ url()->full() }}'.replace('amp;' , '');
    async function loadData() {
        var param = {
            method: 'GET',
            url: url,
        }
        
        await transAjax(param).then(function(result) {
            $('#x-data-table').html(result);
            window.print();
        }).catch((err) => {
            console.log('Internal Server Error!');
        });
    }
    </script>
@endpush