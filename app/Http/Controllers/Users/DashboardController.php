<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Persensi;
use App\Services\PresensiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $presensi = $this->presensi->Query();

            if (request()->bulan) {
                $presensi->whereMonth('tanggal', request()->bulan);
            }

            $data['table'] =  $presensi->where('user_id', auth()->user()->id)->latest()->limit(5)->get();
            return view('users.dashboard._data_table_absensi', $data);
        }
        $data['nama'] = explode(" ", auth()->user()->nama);
        $data['absen'] = Persensi::where('user_id', auth()->user()->id)->where('tanggal', date('Y-m-d'))->first();
        $data['hadir'] = Persensi::where('user_id', auth()->user()->id)->whereMonth('tanggal', date('m'))->count();
        $data['terlambat'] = Persensi::where('user_id', auth()->user()->id)->whereMonth('tanggal', date('m'))->WhereNotNull('status')->count();
        return view('users.dashboard.index', $data);
    }
}
