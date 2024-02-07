<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rsud extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'opd_id',
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'lat_long_masuk',
        'lat_long_pulang',
        'photo_masuk',
        'photo_pulang',
        'status',
        'warning',
        'spt',
        'keterangan',
        'status_pulang'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
