<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Persensi;
use App\Models\User;
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

                //tanggal kemaren
                $yesterday = Carbon::now()->subDays(1)->format('Y-m-d');

                // Ambil OPD ID dari user yang sedang login
                $userId = Auth::user()->id;

                // Ambil OPD ID dari user yang sedang login
                $opdId = Auth::user()->opd_id;

                // Hitung jumlah user di OPD
                $userByOpdId = User::where('opd_id', $opdId)->count();

                // Hitung jumlah presensi kemarin berdasarkan opd_id
                $presensiYesterday = $this->presensi->Query()->where('opd_id', $opdId)
                ->where('tanggal', $yesterday)
                ->count();

                //cek apakah user yang sedang login kemaren presensi atau tidak
                $presensiUserYesterday = $this->presensi->Query()->where('user_id', $userId)
                ->where('tanggal', $yesterday)
                ->count();
                // Bandingkan jumlah presensi dengan setengah dari jumlah user
                if ($presensiYesterday >= $userByOpdId / 2) {
                    if($presensiUserYesterday === 0) {
                        //cek apakah user yang login sedang cuti atau tidak
                        $cuti = Izin::where('user_id', $userId)->latest()->first();
                        if($cuti) {
                            //jika ada cuti cek apakah tanggal masuk sudah lewat/belum
                            $tanggalMasukCuti = Carbon::createFromDate($cuti->tanggal_masuk);
                            // Periksa apakah tanggal tersebut sudah lewat dari hari ini
                            if ($tanggalMasukCuti->isPast()) {
                                $data = [
                                    'opd_id' => Auth::user()->opd_id,
                                    'user_id'   => Auth::user()->id,
                                    'tanggal'   => $yesterday,
                                    'jam_masuk' => '0',
                                    'jam_pulang'    => '0',
                                    'lat_long_masuk'    => '0',
                                    'lat_long_pulang'   => '0',
                                    'photo_masuk'       => "no_image.png",
                                    'status'            => 'Tidak Presensi',
                                ];
                                try {
                                    $this->presensi->store($data);
                                } catch (\Throwable $th) {
                                    throw $th;
                                };
                                //kurangi TPP karena user tdk masuk
                            };
                        }else {
                            //user tdk sedang cuti
                            $data = [
                                'opd_id' => Auth::user()->opd_id,
                                'user_id'   => Auth::user()->id,
                                'tanggal'   => $yesterday,
                                'jam_masuk' => '0',
                                'jam_pulang'    => '0',
                                'lat_long_masuk'    => '0',
                                'lat_long_pulang'   => '0',
                                'photo_masuk'       => "no_image.png",
                                'status'            => 'Tidak Presensi',
                            ];
                            try {
                                $this->presensi->store($data);
                            } catch (\Throwable $th) {
                                throw $th;
                            };
                            //kurangi TPP karena user tdk masuk
                        }
                    }
                }
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
            return Persensi::where('user_id', auth()->user()->id)->where('status', 'Dinas Luar (DL)')->count();
        });

        return view('users.dashboard.index', $data);
    }
}
