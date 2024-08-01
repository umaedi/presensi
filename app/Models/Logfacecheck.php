<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logfacecheck extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'log_type',
        'face'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function logfacecheck()
    {
        return $this->belongsTo('user_id', 'user_id');
    }
}
