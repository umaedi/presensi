@extends('layouts.opd.print')
@section('content')
<div class="card">
    <p><span class="font-weight-bold">OPD:</span> {{ $pegawai->opd->nama_opd }}</p>
    <p><span class="font-weight-bold">NIP:</span> {{ $pegawai->nip }}</p>
    <p><span class="font-weight-bold">Nama:</span> {{ $pegawai->name }}</p>
    <p><span class="font-weight-bold">Email:</span> {{ $pegawai->email }}</p>
    <p><span class="font-weight-bold">No Tlp:</span> {{ $pegawai->no_tlp }}</p>
    <div class="table-responsive" id="x-data-table">
    
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