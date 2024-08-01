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
}
