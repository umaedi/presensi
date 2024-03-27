<?php

namespace App\Http\Controllers\Oprator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\StatuspegawaiService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StatuspegawaiController extends Controller
{
    protected $statuspegawai;
    protected $user;
    public function __construct(StatuspegawaiService $statuspegawaiService, UserService $userService)
    {
        $this->statuspegawai = $statuspegawaiService;
        $this->user = $userService;
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
            'status'    => 'required|string|max:50|unique:statuspegawais,opd_id,' . Auth::user()->opd_id,
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

    public function show($id)
    {
        if (\request()->ajax()) {
            dd('ok');
        }
        $data['title'] = 'Status Pegawai';
        $data['status'] = $this->statuspegawai->find($id);
        return view('oprator.statuspegawai.show', $data);
    }

    public function update(Request $request)
    {
        $user_id = $request->user_id;
        $data['status_pegawai'] = $request->status;
        try {
            $this->user->update($user_id, $data);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $this->success('ok', 'Data berhasil diperbaharui');
    }
}
