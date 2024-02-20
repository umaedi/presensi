<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'log_description',
        'logtype',
    ];

    public static function booted()
    {
        parent::booted();
        static::creating(function ($model) {
            try {
                Http::post('https://api.telegram.org/bot6903681474:AAF3llrIatSkUcsKI5KIVAxziwqNrlvXvJk/sendMessage', [
                    'chat_id' => env('CHAT_ID'),
                    'text' => $model->log_description,
                ]);
            } catch (\Exception $e) {
                Http::post('https://api.telegram.org/bot6903681474:AAF3llrIatSkUcsKI5KIVAxziwqNrlvXvJk/sendMessage', [
                    'chat_id' => env('CHAT_ID'),
                    'text' => 'error' . $model->log_description,
                ]);
            }
        });
    }
};
