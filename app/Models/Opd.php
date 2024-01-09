<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_opd',
        'jam_masuk',
        'jam_pulang',
        'radius'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function presensicount()
    {
        return $this->hasMany(Presensicount::class);
    }
}
