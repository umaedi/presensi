<?php

namespace App\Services;

use App\Models\Persensi;


class PresensiService
{
    protected $presensi;
    public function __construct(Persensi $presensi)
    {
        $this->presensi = $presensi;
    }

    public function store($data)
    {
        return  $this->presensi->create($data);
    }

    public function find($id)
    {
        return $this->presensi->find($id);
    }

    public function update($presensi, $data)
    {
        return $presensi->update($data);
    }

    public function Query()
    {
        return $this->presensi->query();
    }
}
