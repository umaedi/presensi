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

if (!function_exists('telegramNotification')) {
    function telegramNotification($status, $description)
    {
        $response = Http::post('https://api.telegram.org/bot6903681474:AAF3llrIatSkUcsKI5KIVAxziwqNrlvXvJk/sendMessage', [
            'chat_id'   => config('app.chat_id'),
            'text'    => $status . ', ' . $description . Auth::user()->nama,
        ]);
    }
}

if (!function_exists('formatRp')) {
    function formatRp($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}

if (!function_exists('Usercount')) {
    function Usercount()
    {
        $count_user = Presensicount::where('opd_id', Auth::user()->opd_id)->count();
        if ($count_user !== 0) {
            Presensicount::where('opd_id', Auth::user()->opd_id)->increment('total_user');
        } else {
            $datauser = [
                'opd_id' => Auth::user()->opd_id,
                'total_user' => 1,
                'total_presensi' => 0,
            ];
            Presensicount::create($datauser);
        }
    }
}

if (!function_exists('Presensicount')) {
    function Presensicount()
    {
        $presensiCount = Presensicount::where('opd_id', Auth::user()->opd_id)
            ->whereDate('updated_at', Carbon::now()->toDateString())
            ->count();

        if ($presensiCount !== 0) {
            Presensicount::where('opd_id', Auth::user()->opd_id)
                ->whereDate('updated_at', Carbon::now()->toDateString())
                ->increment('total_presensi');
        } else {
            Presensicount::where('opd_id', Auth::user()->opd_id)->update(['total_presensi' => 1]);
        }
    }
}
