<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'opd_id',
        'nip',
        'nama',
        'jabatan',
        'unit_organisasi',
        'email',
        'password',
        'no_hp',
        'photo',
        'role',
        'web_token',
        'status_pegawai',
        'tpp'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

    public function persensi()
    {
        return $this->hasMany(Persensi::class);
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function subopd()
    {
        return $this->belongsTo(SubOpd::class, 'sub_opd_id');
    }

    public function izin()
    {
        return $this->hasMany(Izin::class);
    }
}
