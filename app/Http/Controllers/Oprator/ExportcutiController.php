<?php

namespace App\Http\Controllers\Oprator;

use App\Exports\CutiExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\IzinService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportcutiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected $cuti;
    public function __construct(IzinService $izinService)
    {
        $this->cuti = $izinService;
    }
    public function __invoke(Request $request)
    {
        $cuti = $this->cuti->Query()->where('opd_id', Auth::user()->opd_id)->get();
        return Excel::download(new CutiExport($cuti), Carbon::now() . '.presensi.xlsx');
    }
}
