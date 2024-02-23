<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_opd',
        'lat',
        'long',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function subopd()
    {
        return $this->hasMany(SubOpd::class);
    }

    public function presensi()
    {
        return $this->hasMany(Persensi::class);
    }

    public function shift()
    {
        return $this->hasMany(Shift::class);
    }

    public function presensicount()
    {
        return $this->hasMany(Presensicount::class);
    }
}
