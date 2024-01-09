<?php

namespace App\Services;

use App\Models\Presensicount;

class PresensicountService
{
    protected $presensiCount;
    public function __construct(Presensicount $presensicount)
    {
        $this->presensiCount = $presensicount;
    }

    public function Query()
    {
        return $this->presensiCount->query();
    }
}
