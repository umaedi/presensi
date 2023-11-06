<?php

namespace App\Imports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Pegawai([
            'opd_id'    => auth()->guard('opd')->user()->id,
            'nip'       => (int)$row['nip'],
            'name'      => $row['nama'],
            'jabatan'   => $row['jabatan'],
            'email'     => $row['email'],
            'no_tlp'    => $row['no_tlp'],
            'password'  => $row['password'],
        ]);
    }
}
