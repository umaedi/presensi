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

    public function Query()
    {
        return $this->opd->query();
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
