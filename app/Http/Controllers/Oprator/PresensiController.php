<?php

namespace App\Http\Controllers\Oprator;

use App\Http\Controllers\Controller;
use App\Models\Statuspegawai;
use App\Services\PresensiService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    protected $user;
    protected $presensi;
    public function __construct(PresensiService $presensiService)
    {
        $this->presensi = $presensiService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $presensi = $this->presensi->Query();
            if (\request()->tanggal_awal && \request()->tanggal_akhir) {
                $tgl_awal = Carbon::parse(\request()->tanggal_awal)->toDateTimeString();
                $tgl_akhir = Carbon::parse(\request()->tanggal_akhir)->toDateTimeString();
                $presensi->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
            }

            if (isset(request()->status)) {
                if (request()->status !== 'Terlambat') {
                    $presensi->where('status', \request()->status);
                } else {
                    $presensi->where('status', 'like', '%' . 'Terlambat' . '%');
                }
            }

            $data['table'] = $presensi->where('opd_id', Auth::user()->opd_id)->latest()->paginate();
            return view('oprator.presensi._data_presensi', $data);
        }

        $data['title'] = 'Master Presensi';
        $data['status'] = Statuspegawai::where('opd_id', Auth::user()->opd_id)->get();
        return view('oprator.presensi.index', $data);
    }
}
