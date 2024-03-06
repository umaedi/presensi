<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Persensi;
use App\Services\PresensiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public $presensi;
    public function __construct(PresensiService $presensiService)
    {
        $this->presensi = $presensiService;
    }

    public function __invoke(Request $request)
    {
        if (request()->ajax()) {
            //save cache
            $minutes = now()->addDays(1)->diffInMinutes(now());

            if (request()->bulan) {
                $presensi = $this->presensi->Query();
                $presensi->whereMonth('tanggal', request()->bulan);
                $data['table'] =  $presensi->where('user_id', auth()->user()->id)->latest()->limit(5)->get();
                return view('users.dashboard._data_table_absensi', $data);
            }

            $data['table'] = Cache::remember('table_dashboard_' . Auth::user()->id, $minutes, function () {
                return Persensi::where('user_id', Auth::user()->id)->latest()->limit(5)->get();
            });
            return view('users.dashboard._data_table_absensi', $data);
        }

        // $data['nama'] = explode(" ", auth()->user()->nama);
        // $data['absen'] = Persensi::where('user_id', auth()->user()->id)->where('tanggal', date('Y-m-d'))->first();
        // $data['cuti'] = Persensi::where('user_id', auth()->user()->id)->where('status', 'cuti')->count();
        // $data['hadir'] = Persensi::where('user_id', auth()->user()->id)->whereMonth('tanggal', date('m'))->count();
        // $data['terlambat'] = $this->presensi->Query()->where('user_id', Auth::user()->id)->whereMonth('tanggal', date('m'))->where('status', 'like', '%' . 'Terlambat' . '%')->count();
        // $data['dl'] = Persensi::where('user_id', auth()->user()->id)->where('status', 'DL')->count();

        //save cache
        $minutes = now()->addDays(1)->diffInMinutes(now());

        $data['nama'] = explode(" ", auth()->user()->nama);
        $data['absen'] = Cache::remember('absen_' . auth()->user()->id, $minutes, function () {
            return Persensi::where('user_id', auth()->user()->id)->where('tanggal', date('Y-m-d'))->first();
        });
        $data['cuti'] = Cache::remember('cuti_' . auth()->user()->id, $minutes, function () {
            return Persensi::where('user_id', auth()->user()->id)->where('status', 'cuti')->count();
        });
        $data['hadir'] = Cache::remember('hadir_' . auth()->user()->id, $minutes, function () {
            return Persensi::where('user_id', auth()->user()->id)->whereMonth('tanggal', date('m'))->count();
        });
        $data['terlambat'] = Cache::remember('terlambat_' . auth()->user()->id, $minutes, function () {
            return $this->presensi->Query()->where('user_id', Auth::user()->id)->whereMonth('tanggal', date('m'))->where('status', 'like', '%' . 'Terlambat' . '%')->count();
        });
        $data['dl'] = Cache::remember('dl_' . auth()->user()->id, $minutes, function () {
            return Persensi::where('user_id', auth()->user()->id)->where('status', 'DL')->count();
        });

        return view('users.dashboard.index', $data);
    }
}
