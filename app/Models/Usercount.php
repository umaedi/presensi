<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usercount extends Model
{
    use HasFactory;
    protected $fillable = [
        'opd_id',
        'total_user',
        'total_presensi'
    ];
}
