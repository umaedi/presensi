<?php

namespace App\Services;

use App\Models\Izin;

class izinService
{
    public $izin;
    public function __construct(Izin $izin)
    {
        $this->izin = $izin;
    }

    public function Query()
    {
        return $this->izin->query();
    }
}
