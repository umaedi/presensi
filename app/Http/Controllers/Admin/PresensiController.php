<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Services\OpdService;
use Illuminate\Http\Request;
use App\Services\PresensiService;
use App\Http\Controllers\Controller;

class PresensiController extends Controller
{
    protected $opd;
    protected $presensi;
    public function __construct(OpdService $opdService, PresensiService $presensiService)
    {
        $this->opd = $opdService;
        $this->presensi = $presensiService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $presensi = $this->presensi->Query();

            if (isset($request->search)) {
                $presensi->whereHas('user', function ($query) {
                    $query->where('nama', 'like', '%' . \request()->search . '%')
                        ->orWhere('nip', \request()->search);
                });
            }
            if (isset($request->opd)) {
                $presensi->where('opd_id', $request->opd);
            }

            if ($request->tanggal_awal && $request->tanggal_akhir) {
                $tgl_awal = Carbon::parse($request->tanggal_awal)->toDateTimeString();
                $tgl_akhir = Carbon::parse($request->tanggal_akhir)->toDateTimeString();
                $presensi->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
            }

            if (isset($request->status)) {
                if (request()->status !== 'Terlambat') {
                    $presensi->where('status', $request->status);
                } else {
                    $presensi->where('status', 'like', '%' . 'Terlambat' . '%');
                }
            }

            $data['table'] = $presensi->with('opd')->latest()->paginate();
            return view('admin.presensi._data_presensi_opd', $data);
        }
        $data['title'] = 'Laporan presensi pegawai';
        $data['opds'] = $this->opd->getAll();
        return view('admin.presensi.index', $data);
    }
}
