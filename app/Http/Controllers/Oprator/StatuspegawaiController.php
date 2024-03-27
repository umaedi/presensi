<?php

namespace App\Http\Controllers\Oprator;

use App\Http\Controllers\Controller;
use App\Services\StatuspegawaiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StatuspegawaiController extends Controller
{
    protected $statuspegawai;
    public function __construct(StatuspegawaiService $statuspegawaiService)
    {
        $this->statuspegawai = $statuspegawaiService;
    }

    public function index()
    {
        if (request()->ajax()) {
            $data['table'] = $this->statuspegawai->Query()->where('opd_id', Auth::user()->opd_id)->get();
            return view('oprator.statuspegawai._data_status', $data);
        }
        return view('oprator.statuspegawai.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status'    => 'required|string|unique:statuspegawais|max:50'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = $request->except('_token');
        $data['opd_id'] = Auth::user()->opd_id;
        try {
            $this->statuspegawai->store($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $this->success('ok', 'Data berhasil ditambahkan');
    }
}
