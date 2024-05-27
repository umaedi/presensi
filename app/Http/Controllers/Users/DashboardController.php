<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Persensi;
use App\Services\PresensiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

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
            //cek presensi
            $weekend = $yesterday = Carbon::yesterday();
            if(!$weekend->isWeekend()) {
                $yesterday = Carbon::now()->subDays(1)->format('Y-m-d');
                $presensiYesterday = $this->presensi->Query()->where('opd_id', Auth::user()->opd_id)->where('tanggal', $yesterday)->count();
                // if($presensiYesterday > 7) {
                    $presensiUser = $this->presensi->Query()->where('user_id', Auth::user()->id)->where('tanggal', $yesterday)->count();
                    if($presensiUser == 0) {
                        //cek cuty
                        $cuty = Izin::where('user_id', Auth::user()->id)->latest()->first();
                        $tanggal_tentu = Carbon::createFromDate($cuty->tanggal_masuk);
                        // Periksa apakah tanggal tersebut sudah lewat dari hari ini
                        if ($tanggal_tentu->isPast()) {
                            $data = [
                                'opd_id' => Auth::user()->opd_id,
                                'user_id'   => Auth::user()->id,
                                'tanggal'   => $yesterday,
                                'jam_masuk' => '0',
                                'jam_pulang'    => '0',
                                'lat_long_masuk'    => '0',
                                'lat_long_pulang'   => '0',
                                'photo_masuk'       => "no_image.png",
                                'status'            => 'Tidak Masuk',
                            ];
                            try {
                                $this->presensi->store($data);
                            } catch (\Throwable $th) {
                                throw $th;
                            };
                        };
                    };
                // };
            };

            $minutes = 720;
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
        $minutes = 720;

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
