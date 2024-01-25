<?php

namespace App\Http\Controllers\Oprator;

use App\Exports\PresensiExport;
use Carbon\Carbon;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Services\PresensiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportUsers extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected $presensi;
    public function __construct(PresensiService $presensiService)
    {
        $this->presensi = $presensiService;
    }
    public function __invoke(Request $request)
    {
        $presensi = $this->presensi->Query();
        // if (\request()->tanggal_awal && \request()->tanggal_akhir) {
        //     $tgl_awal = Carbon::parse(\request()->tanggal_awal)->toDateTimeString();
        //     $tgl_akhir = Carbon::parse(\request()->tanggal_akhir)->toDateTimeString();
        //     $presensi->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
        // }

        // if (isset(request()->status)) {
        //     if (request()->status !== 'Terlambat') {
        //         $presensi->where('status', \request()->status);
        //     } else {
        //         $presensi->where('status', 'like', '%' . 'Terlambat' . '%');
        //     }
        // }

        $presensi = $presensi->where('opd_id', Auth::user()->opd_id)->get();
        return Excel::download(new PresensiExport($presensi), 'users.xlsx');
    }
}
