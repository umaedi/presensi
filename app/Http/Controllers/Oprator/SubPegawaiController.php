<?php

namespace App\Http\Controllers\Oprator;

use App\Http\Controllers\Controller;
use App\Services\SubOpdService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SubPegawaiController extends Controller
{
    protected $user;
    protected $subopd;
    public function __construct(SubOpdService $subOpdService, UserService $userService)
    {
        $this->subopd = $subOpdService;
        $this->user   = $userService;
    }

    public function index()
    {
        if (\request()->ajax()) {
            $users = $this->user->Query();
            if (\request()->search) {
                $users->where('nama', 'like', '%' . \request()->search . '%');
            }
            $data['table'] = $users->where('users.opd_id', Auth::user()->opd_id)
                ->whereNotNull('sub_opd_id')
                ->paginate();
            return view('oprator.subpegawai._data_user', $data);
        }

        $data = [
            'users'   => $this->user->Query()->where('opd_id', Auth::user()->opd_id)->get(),
            'subopds' => $this->subopd->Query()->where('opd_id', 20)->get()
        ];
        return view('oprator.subpegawai.index', compact('data'));
    }

    public function update($id)
    {
        $data['sub_opd_id'] = NULL;
        try {
            $this->user->update($id, $data);
        } catch (\Throwable $th) {
            saveLogs($th->getMessage(), 'Error update profile user');
            return $this->error($th->getMessage());
        }
        return $this->success($data, 'Data pegawai berhasil diperbaharui');
    }

    public function store()
    {
        $validator = Validator::make(\request()->all(), [
            'id'  => 'required',
            'sub_opd_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = \request()->except('_token');
        $data['sub_opd_id'] = request()->sub_opd_id;
        try {
            $this->user->update(request()->id, $data);
        } catch (\Throwable $th) {
            saveLogs($th->getMessage(), 'Error update profile user');
            return $this->error($th->getMessage());
        }
        return $this->success($data, 'Data pegawai berhasil diperbaharui');
    }
}
