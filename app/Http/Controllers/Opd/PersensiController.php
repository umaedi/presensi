<?php

namespace App\Http\Controllers\Opd;

use Carbon\Carbon;
use App\Models\Absent;
use App\Http\Controllers\Controller;
use App\Models\Pegawai;

class PersensiController extends Controller
{
    public function index($id)
    {
        if (\request()->ajax()) {

            $absent = Absent::query();
            $page = request()->get('paginate', 10);

            if (\request()->tgl_awal && \request()->tgl_akhir) {
                $tgl_awal = Carbon::parse(\request()->tgl_awal)->toDateTimeString();
                $tgl_akhir = Carbon::parse(\request()->tgl_akhir)->toDateTimeString();
                $absent->whereBetween('created_at', [$tgl_awal, $tgl_akhir])->get();
            }

            $data['table'] = $absent->where('pegawai_id', $id)->paginate($page);

            return view('opd.persensi._data_table_persensi', $data);
        }

        $data['title'] = 'Riwayat Absensi';
        return view('opd.persensi.index', $data);
    }

    public function print($id)
    {
        $pegawai = Pegawai::findOrfail($id);
        if (request()->ajax()) {

            $page = request()->get('page', 10);
            $absent = Absent::query();

            if (\request()->tgl_awal && \request()->tgl_akhir) {
                $tgl_awal = Carbon::parse(\request()->tgl_awal)->toDateTimeString();
                $tgl_akhir = Carbon::parse(\request()->tgl_akhir)->toDateTimeString();
                $absent->whereBetween('created_at', [$tgl_awal, $tgl_akhir])->get();
            }

            $data['table'] = $absent->where('pegawai_id', $id)->limit($page)->get();

            return view('opd.persensi._data_table_print', $data);
        }

        $title = 'Data Riwayat Absensi ' . $pegawai->name;
        return view('opd.persensi.print', compact('title', 'pegawai'));
    }
}
