<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'opd_id'    => Auth::user()->opd_id,
            'nama'      => $row['nama'],
            'nip'       => $row['nip'],
            'jabatan'   => $row['jabatan'],
            'unit_organisasi'   => $row['unit_organisasi'],
            'email'     => $row['email'],
            'password'   => bcrypt($row['password']),
            'no_hp'     => $row['no_hp'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nip' => 'unique:users,nip',
            'email' => 'unique:users,email',
        ];
    }
}
