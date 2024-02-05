<?php

namespace App\Services;

use App\Models\Kumpul;

class TitikkumpulService
{
    protected $titikkumpul;
    public function __construct(Kumpul $kumpul)
    {
        $this->titikkumpul = $kumpul;
    }

    public function Query()
    {
        return $this->titikkumpul->query();
    }

    public function find($id)
    {
        $model = $this->titikkumpul->find($id);
        return $model;
    }

    public function update($id, $data)
    {
        return $this->titikkumpul->where('id', $id)->update($data);
    }

    public function store($data)
    {
        return $this->titikkumpul->create($data);
    }
}
