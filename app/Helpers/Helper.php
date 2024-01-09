<?php

use App\Models\Log;
use App\Models\Presensicount;
use Illuminate\Support\Carbon;
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
        $count_user = Presensicount::where('opd_id', Auth::user()->opd_id)->count();
        $incemrement = $count_user + 1;
        if ($count_user !== 0) {
            Presensicount::where('opd_id', Auth::user()->opd_id)->update(['total_user' => $incemrement]);
        } else {
            $datauser = [
                'opd_id' => Auth::user()->opd_id,
                'total_user' => 1,
            ];
            Presensicount::create($datauser);
        }
    }
}

if (!function_exists('Presensicount')) {
    function Presensicount()
    {
        $presensiCount = Presensicount::where('opd_id', Auth::user()->opd_id)->where('updated_at', Carbon::now())->count();
        $incemrement = $presensiCount + 1;
        if ($presensiCount !== 0) {
            Presensicount::where('opd_id', Auth::user()->opd_id)->update(['total_presensi' => $incemrement]);
        } else {
            Presensicount::where('opd_id', Auth::user()->opd_id)->update(['total_presensi' => 1]);
        }
    }
}
