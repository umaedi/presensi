<?php

namespace App\Http\Controllers\Pegawai;

use Carbon\Carbon;
use App\Models\Cuty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CutyController extends Controller
{
    public function index()
    {
        $pegawai_id = auth()->guard('pegawai')->user()->id;
        if (\request()->ajax()) {
            $cuty = Cuty::query();

            if (\request()->tanggal_awal && \request()->tanggal_akhir) {
                $tgl_awal = Carbon::parse(\request()->tanggal_awal)->toDateTimeString();
                $tgl_akhir = Carbon::parse(\request()->tanggal_akhir)->toDateTimeString();
                $cuty->whereBetween('created_at', [$tgl_awal, $tgl_akhir])->get();
            }

            $data['table']  = $cuty->where('pegawai_id', $pegawai_id)->paginate(6);
            return view('pegawai.cuty._data_table_cuty', $data);
        }

        $data['title']  = 'Data Permohonan Cuty';
        return view('pegawai.cuty.index', $data);
    }

    public function store()
    {
        if (\request()->ajax()) {
            $cuty = Cuty::create(\request()->except('_token'));
            return response()->json([
                'success'   => true,
                'message'   => 'Permohonan Cuty Berhasil Dibuat',
            ]);
        }
    }

    public function update()
    {
        $pegawai_id = auth()->guard('pegawai')->user()->id;
        if (\request()->ajax()) {
            $cuty = Cuty::findOrfail($pegawai_id);

            $cuty->where('id', request()->cuty_id)->update([
                'tanggal_awal'  => request()->tanggal_awal ? request()->tanggal_awal : $cuty->tanggal_awal,
                'tanggal_akhir' => request()->tanggal_akhir ? request()->tanggal_akhir : $cuty->tanggal_akhir,
                'tanggal_masuk' => request()->tanggal_masuk ? request()->tanggal_masuk : $cuty->tanggal_masuk,
                'jumlah_izin'   => request()->jumlah_izin ? request()->jumlah_izin : $cuty->jumlah_izin,
                'keterangan'    => request()->keterangan ? request()->keterangan : $cuty->keterangan,
                'status'        => request()->status ? request()->status : $cuty->status,
            ]);

            return response()->json([
                'success'   => true,
                'message'   => 'Permohonan Cuty Berhasil Diperbaharui',
            ]);
        }
    }

    public function print(Request $request)
    {
        $pegawai = auth()->guard('pegawai')->user();
        if (\request()->ajax()) {
            $absent = Cuty::query();
            if ($request->tanggal_awal && $request->tanggal_akhir) {
                $tgl_awal = Carbon::parse(\request()->tanggal_awal)->toDateTimeString();
                $tgl_akhir = Carbon::parse(\request()->tanggal_akhir)->toDateTimeString();
                $absent->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
            }

            $data['table'] = $absent->where('pegawai_id', $pegawai->id)->paginate();

            return view('pegawai.cuty._data_table_print', $data);
        }

        $data['title'] = 'Data Izin ' . $pegawai->name;
        return view('pegawai.cuty.print', compact('data'));
    }
}
