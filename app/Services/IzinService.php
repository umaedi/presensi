<?php

namespace App\Services;

use App\Models\Izin;

class IzinService
{
    public $izin;
    public function __construct(Izin $izin)
    {
        $this->izin = $izin;
    }

    public function store($data)
    {
        return $this->izin->create($data);
    }

    public function update($id, $data)
    {
        $model = $this->izin->find($id);
        $model->update($data);
        return $model;
    }

    public function Query()
    {
        return $this->izin->query();
    }
}
