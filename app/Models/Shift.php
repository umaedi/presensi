<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected $fillable = [
        'opd_id',
        'sub_opd_id',
        'nama_shift',
        'jam_masuk',
        'jam_pulang',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function subopd()
    {
        return $this->belongsTo(SubOpd::class);
    }
}
