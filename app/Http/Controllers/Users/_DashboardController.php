<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Absent;
use App\Models\Cuty;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $pegawai = auth()->guard('pegawai')->user();

        if (\request()->ajax()) {
            $absent = Absent::query();

            if (\request()->bulan) {
                $absent->whereMonth('tanggal', request()->bulan);
            }

            $data['table'] =  $absent->where('pegawai_id', $pegawai->id)->latest()->limit(5)->get();
            return view('pegawai.dashboard._data_table_absensi', $data);
        }

        $data['absen'] = Absent::where('pegawai_id', $pegawai->id)->where('tanggal', date('Y-m-d'))->first();
        $data['tanggal'] = Carbon::now()->format('d M Y');
        $data['hadir'] = Absent::where('pegawai_id', $pegawai->id)->count();
        $data['terlambat'] = Absent::where('pegawai_id', $pegawai->id)->where('status', '2')->count();
        $data['pegawai'] = Pegawai::where('opd_id', $pegawai->opd->id)->where('role', 1)->count();
        $data['sakit'] = Cuty::where('pegawai_id', $pegawai->id)->where('status', '2')->count();
        $data['cuty'] = Cuty::where('pegawai_id', $pegawai->id)->where('status', '3')->count();

        $data['title'] = 'Dashboard Stap';

        return view('pegawai.dashboard.index', $data);
    }
}
