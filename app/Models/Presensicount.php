<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensicount extends Model
{
    use HasFactory;
    protected $fillable = [
        'opd_id',
        'total_user',
        'total_presensi'
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
