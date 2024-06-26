<?php

namespace App\Services;

use App\Models\Opd;

class OpdService
{
    protected $opd;
    public function __construct(Opd $opd)
    {
        $this->opd = $opd;
    }

    public function getAll()
    {
        return $this->opd->get();
    }

    public function store($data)
    {
        return $this->opd->create($data);
    }

    public function Query()
    {
        return $this->opd->query();
    }

    public function find($id)
    {
        $opd = $this->opd->find($id);
        return $opd;
    }
    public function show($id)
    {
        $opd = $this->opd->find($id);
        return $opd;
    }

    public function update($id, $data)
    {
        $opd =  $this->opd->where('id', $id)->update($data);
        return $opd;
    }
}
