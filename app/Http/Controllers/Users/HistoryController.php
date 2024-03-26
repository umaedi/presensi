<?php

namespace App\Http\Controllers\Users;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Persensi;
use App\Services\PresensiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HistoryController extends Controller
{
    public $presensi;
    public function __construct(PresensiService $presensiService)
    {
        $this->presensi = $presensiService;
    }
    public function index()
    {
        $minutes = 720;
        if (\request()->ajax()) {
            if (request()->page > "1") {
                $presensi = $this->presensi->Query();
                $data['table'] = $presensi->where('user_id', auth()->user()->id)->latest()->paginate(15);
                return view('users.history._data_table_history', $data);
            }

            if (\request()->tanggal_awal && \request()->tanggal_akhir) {
                $presensi = $this->presensi->Query();
                $tgl_awal = Carbon::parse(\request()->tanggal_awal)->toDateTimeString();
                $tgl_akhir = Carbon::parse(\request()->tanggal_akhir)->toDateTimeString();
                $data['table'] = $presensi->where('user_id', Auth::user()->id)->whereBetween('created_at', [$tgl_awal, $tgl_akhir])->latest()->paginate(15);
                return view('users.history._data_table_history', $data);
            }
            $data['table'] = Cache::remember('history_' . Auth::user()->id, $minutes, function () {
                return Persensi::where('user_id', Auth::user()->id)->latest()->paginate(15);
            });
            return view('users.history._data_table_history', $data);
        }

        $data['tanggal'] = Carbon::now()->format('d M Y');
        $data['hadir'] = Cache::remember('history_hadir_' . Auth::user()->id, $minutes, function () {
            return Persensi::where('user_id', auth()->user()->id)->count();
        });
        $data['terlambat'] = Cache::remember('history_terlambat_' . Auth::user()->id, $minutes, function () {
            return Persensi::where('user_id', Auth::user()->id)->where('status', 'like', '%' . 'Terlambat' . '%')->count();
        });
        $data['dl'] = Cache::remember('history_dl_' . Auth::user()->id, $minutes, function () {
            return Persensi::where('user_id', Auth::user()->id)->where('status', 'DL')->count();
        });
        $data['apel'] = Cache::remember('history_apel_' . Auth::user()->id, $minutes, function () {
            return Persensi::where('user_id', Auth::user()->id)->where('status', 'Apel')->count();
        });
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

            $data['table'] = $presensi->where('user_id', auth()->user()->id)->latest()->paginate(15);
            return view('users.history._data_table_print', $data);
        }

        $data['title'] = 'Data Riwayat Presensi ' . auth()->user()->nama;
        return view('users.history.print', compact('data'));
    }
}
