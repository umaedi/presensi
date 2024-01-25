<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PresensiExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $presensi;
    public function __construct($presensi)
    {
        $this->presensi = $presensi;
    }

    public function collection()
    {
        return $this->presensi;
    }

    public function map($presensi): array
    {
        return [
            $presensi->tanggal,
            $presensi->user->nama,
            $presensi->jam_masuk,
            $presensi->jam_pulang,
            $presensi->status,
        ];
    }

    public function headings(): array
    {
        return [
            'TANGGAL',
            'NAMA',
            'JAM MASUK',
            'JAM PULANG',
            'STATUS',
        ];
    }
}
