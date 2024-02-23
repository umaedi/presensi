<?php

namespace App\Services;

use App\Models\Shift;

class ShiftService
{
    protected $shift;
    public function __construct(Shift $shift)
    {
        return $this->shift = $shift;
    }

    public function Query()
    {
        return $this->shift->query();
    }

    public function find($id)
    {
        $model = $this->shift->find($id);
        return $model;
    }

    public function update($id, $data)
    {
        return $this->shift->where('id', $id)->update($data);
    }

    public function store($data)
    {
        return $this->shift->create($data);
    }
}
