<?php

namespace App\Services;

use App\Models\Rsud;

class RsudService
{
    protected $rsud;
    public function __construct(Rsud $rsud)
    {
        $this->rsud = $rsud;
    }

    public function store($data)
    {
        return $this->rsud->create($data);
    }

    public function find($id)
    {
        return $this->rsud->find($id);
    }

    public function update($presensi, $data)
    {
        return $presensi->update($data);
    }

    public function Query()
    {
        return $this->rsud->query();
    }
}
