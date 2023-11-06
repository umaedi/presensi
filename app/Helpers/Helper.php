<?php

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

if (!function_exists('saveLogs')) {
    function saveLogs($description, $logType)
    {
        $dataLog = [
            'user_id' => Auth::user()->id,
            'log_description'   => Auth()->user()->nama  . ' ' . $description,
            'logtype'   => $logType,
        ];
        Log::create($dataLog);
    }
}
