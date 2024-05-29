<?php

namespace App\Services;

use App\Models\SubOpd;

class SubOpdService
{
    protected $subopd;
    public function __construct(SubOpd $subopd)
    {
        $this->subopd = $subopd;
    }

    public function getAll()
    {
        return $this->subopd->get();
    }

    public function store($data)
    {
        return $this->subopd->create($data);
    }

    public function Query()
    {
        return $this->subopd->query();
    }

    public function show($id)
    {
        $subopd = $this->subopd->find($id);
        return $subopd;
    }

    public function find($id)
    {
        return $this->subopd->find($id);
    }
    
    public function update($id, $data)
    {
        $subopd =  $this->subopd->where('id', $id)->update($data);
        return $subopd;
    }
}
