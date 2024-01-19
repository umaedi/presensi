<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Services\IzinService;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IzinController extends Controller
{
    public $izin;
    public function __construct(IzinService $izinService)
    {
        $this->izin = $izinService;
    }
    public function index()
    {
        if (\request()->ajax()) {
            $izin = $this->izin->Query();

            if (\request()->tanggal_awal && \request()->tanggal_akhir) {
                $tgl_awal = Carbon::parse(\request()->tanggal_awal)->toDateTimeString();
                $tgl_akhir = Carbon::parse(\request()->tanggal_akhir)->toDateTimeString();
                $izin->whereBetween('created_at', [$tgl_awal, $tgl_akhir])->get();
            }

            $data['table']  = $izin->where('user_id', auth()->user()->id)->paginate(6);
            return view('users.izin._data_table_cuty', $data);
        }

        $data['title']  = 'Data Izin';
        return view('users.izin.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_awal'  => 'required|max:255',
            'tanggal_akhir' => 'required|max:255',
            'tanggal_masuk' => 'required|max:255',
            'jumlah_izin' => 'required|max:255',
            'keterangan'    => 'string|max:255',
            'lampiran'  => 'file|mimes:jpg,jpeg,png,pdf,docx|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = $request->except('_token');
        if ($request->lampiran) {
            $lampiran = $request->file('lampiran');
            $lampiran->storeAs('public/lampiran', $lampiran->hashName());
            $data['lampiran'] = $lampiran->hashName();
        }

        $data['user_id'] = Auth::user()->id;

        try {
            $this->izin->store($data);
        } catch (\Throwable $th) {
            saveLogs($th->getMessage() . '-error ketika membuat surat izin-' . Auth::user()->nama, 'error');
            return $this->error($th->getMessage());
        }

        return $this->success($data, 'Permohonan berhasil dibuat');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_awal'  => 'required|max:255',
            'tanggal_akhir' => 'required|max:255',
            'tanggal_masuk' => 'required|max:255',
            'jumlah_izin' => 'required|max:255',
            'lampiran'  => 'file|mimes:pdf,docx|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = $request->except('_token');
        if ($request->lampiran) {
            $lampiran = $request->file('lampiran');
            $lampiran->storeAs('public/lampiran', $lampiran->hashName());
            $data['lampiran'] = $lampiran->hashName();
        }

        $id = $request->id;
        try {
            $this->izin->update($id, $data);
        } catch (\Throwable $th) {
            saveLogs($th->getMessage() . '-error ketika update data izin-' . Auth::user()->nama, 'error');
            return $this->error($th->getMessage());
        }
        return $this->success($data, 'Permohonan berhasil diupdate');
    }

    public function print(Request $request)
    {
        if (\request()->ajax()) {
            $absent = $this->izin->Query();
            if ($request->tanggal_awal && $request->tanggal_akhir) {
                $tgl_awal = Carbon::parse(\request()->tanggal_awal)->toDateTimeString();
                $tgl_akhir = Carbon::parse(\request()->tanggal_akhir)->toDateTimeString();
                $absent->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
            }

            $data['table'] = $absent->where('user_id', Auth::user()->id)->paginate();

            return view('users.izin._data_table_print', $data);
        }

        $data['title'] = 'Data Izin ' .  Auth::user()->nama;
        return view('users.izin.print', compact('data'));
    }
}
