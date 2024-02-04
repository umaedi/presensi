<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kumpul extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_lokasi',
        'lat',
        'long',
        'status'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function presensi()
    {
        return $this->hasMany(Persensi::class);
    }

    public function presensicount()
    {
        return $this->hasMany(Presensicount::class);
    }
}
