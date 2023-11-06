<?php

namespace App\Http\Controllers\Opd;

use Carbon\Carbon;
use App\Models\Cuty;
use App\Models\Absent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pegawai;

class Dashboard extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $opd = auth()->guard('opd')->user();

        if (\request()->ajax()) {
            $absensi = Absent::query();

            $data['table'] = $absensi->where('opd_id', 1)->where('tanggal', date('Y-m-d'))->get();
            return view('opd.dashboard._data_table_stap', $data);
        }

        $data['pegawai']   = Pegawai::where('opd_id', $opd->id)->where('role', 1)->count();
        $data['hadir'] = Absent::where('opd_id', $opd->id)->whereDate('tanggal', date('Y-m-d'))->count();
        $data['terlambat'] = Absent::where('opd_id', $opd->id)->where('status', '2')->whereDate('tanggal', date('Y-m-d'))->count();
        $data['izin'] = Cuty::where('opd_id', $opd->id)->where('status', '2')->whereDate('created_at', date('Y-m-d'))->count();
        $data['tanggal'] = Carbon::now()->isoFormat('dddd, D MMMM Y');
        return view('opd.dashboard.index', $data);
    }
}
