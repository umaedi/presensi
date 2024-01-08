<?php

use App\Models\Log;
use App\Models\Usercount;
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

if (!function_exists('Usercount')) {
    function Usercount()
    {
        $count_user = Usercount::where('opd_id', Auth::user()->opd_id)->count();
        $incemrement = $count_user + 1;
        if ($count_user !== 0) {
            Usercount::where('opd_id', Auth::user()->opd_id)->update(['total_user' => $incemrement]);
        } else {
            $datauser = [
                'opd_id' => Auth::user()->opd->id,
                'total_user' => 1,
            ];
            Usercount::create($datauser);
        }
    }
}
