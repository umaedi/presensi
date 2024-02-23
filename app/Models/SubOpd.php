<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubOpd extends Model
{
    use HasFactory;

    protected $table = 'sub_opds';
    protected $fillable = [
        'opd_id',
        'nama_sub_opd',
        'lat',
        'long',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    public function shift()
    {
        return $this->hasMany(Shift::class);
    }
}
