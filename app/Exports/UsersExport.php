<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $users;
    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function map($grades): array
    {
        return [
            $grades->nama,
            $grades->email,
            $grades->no_hp,
        ];
    }

    public function headings(): array
    {
        return [
            'NAMA',
            'EMAIL',
            'NO HP',
        ];
    }
}
