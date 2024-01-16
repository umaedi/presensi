<?php

namespace App\Http\Controllers\Users;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Persensi;
use App\Services\PresensiService;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public $presensi;
    public function __construct(PresensiService $presensiService)
    {
        $this->presensi = $presensiService;
    }
    public function index()
    {
        if (\request()->ajax()) {
            $presensi = $this->presensi->Query();

            if (\request()->tanggal_awal && \request()->tanggal_akhir) {
                $tgl_awal = Carbon::parse(\request()->tanggal_awal)->toDateTimeString();
                $tgl_akhir = Carbon::parse(\request()->tanggal_akhir)->toDateTimeString();
                $presensi->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
            }

            $data['table'] = $presensi->where('user_id', auth()->user()->id)->latest()->paginate(12);
            return view('users.history._data_table_history', $data);
        }

        // $absent = Absent::query();
        // $cuty = Cuty::query();

        $data['tanggal'] = Carbon::now()->format('d M Y');
        $data['hadir'] = Persensi::where('user_id', auth()->user()->id)->count();
        $data['terlambat'] = Persensi::where('user_id', auth()->user()->id)->whereNotNull('status')->count();
        $data['dl'] = $this->presensi->Query()->where('user_id', Auth::user()->id)->where('status', 'dl')->count();
        $data['cuti'] = Izin::where('user_id', Auth::user()->id)->count();
        $data['title'] = 'Data History Absensi';

        return view('users.history.index', $data);
    }

    public function print(Request $request)
    {
        if (\request()->ajax()) {
            $presensi = $this->presensi->Query();
            if ($request->tanggal_awal && $request->tanggal_akhir) {
                $tgl_awal = Carbon::parse(\request()->tanggal_awal)->toDateTimeString();
                $tgl_akhir = Carbon::parse(\request()->tanggal_akhir)->toDateTimeString();
                $presensi->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
            }

            $data['table'] = $presensi->where('user_id', auth()->user()->id)->paginate();

            return view('users.history._data_table_print', $data);
        }

        $data['title'] = 'Data Riwayat Presensi ' . auth()->user()->nama;
        return view('users.history.print', compact('data'));
    }
}
