<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuty extends Model
{
    use HasFactory;
    protected $fillable = [
        'opd_id',
        'pegawai_id',
        'tanggal_awal',
        'tanggal_akhir',
        'tanggal_masuk',
        'jumlah_izin',
        'keterangan',
        'status'
    ];

    public function stap()
    {
        return $this->belongsTo(Stap::class);
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
