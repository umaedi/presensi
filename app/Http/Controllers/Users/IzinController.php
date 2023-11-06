<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Services\izinService;
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
        $this->validate($request, [
            'izin' => 'required|max:255',
            'tanggal_awal'  => 'required|max:255',
            'tanggal_akhir' => 'required|max:255',
            'tanggal_masuk' => 'required|max:255',
            'jumlah_izin' => 'required|max:255',
        ]);

        $data = $request->except('_token');
        $data['user_id'] = Auth::user()->id;

        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
