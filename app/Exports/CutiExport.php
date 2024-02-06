<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CutiExport implements FromCollection, WithMapping, WithHeadings
{
    protected $cuti;
    public function __construct($cuti)
    {
        $this->cuti = $cuti;
    }

    public function collection()
    {
        return $this->cuti;
    }

    public function map($cuti): array
    {
        return [
            $cuti->user->nama,
            $cuti->user->nip,
            $cuti->tanggal_awal,
            $cuti->tanggal_akhir,
            $cuti->tanggal_masuk,
            $cuti->jumlah_izin . ' Hari',
            $cuti->keterangan,
            'https://presensi.tulangbawangkab.go.id/storage/lampiran/' . $cuti->lampiran,
        ];
    }

    public function headings(): array
    {
        return [
            'NAMA PEGAWAI',
            'NIP',
            'TANGGAL AWAL',
            'NAMA TANGGAL AKHIR',
            'TANGGAL MASUK',
            'JUMLAH CUTI',
            'KETERANGAN',
            'LAMPIRAN',
        ];
    }
}
