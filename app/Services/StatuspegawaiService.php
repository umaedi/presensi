<?php

namespace App\Services;

use App\Models\Statuspegawai;


class StatuspegawaiService
{
    protected $statuspegawai;
    public function __construct(Statuspegawai $statuspegawai)
    {
        $this->statuspegawai = $statuspegawai;
    }

    public function Query()
    {
        return $this->statuspegawai->query();
    }

    public function store($data)
    {
        return $this->statuspegawai->create($data);
    }

    public function find($id)
    {
        return $this->statuspegawai->find($id);
    }
}
