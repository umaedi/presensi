<?php

namespace App\Http\Controllers\Oprator;

use App\Http\Controllers\Controller;
use App\Models\Statuspegawai;
use App\Services\PresensiService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    protected $user;
    protected $presensi;
    public function __construct(UserService $userService, PresensiService $presensiService)
    {
        $this->user = $userService;
        $this->presensi = $presensiService;
    }

    public function index()
    {
        if (\request()->ajax()) {
            $users = $this->user->Query();
            if (\request()->search) {
                $users->where('nama', 'like', '%' . \request()->search . '%');
            }
            $data['table'] = $users->where('opd_id', Auth::user()->opd_id)->paginate();
            $data['status'] = Statuspegawai::where('opd_id', Auth::user()->opd_id)->get();
            return view('oprator.users._data_user', $data);
        }
        return view('oprator.users.index');
    }

    public function store()
    {
        $validator = Validator::make(\request()->all(), [
            'nama'  => 'required|string|max:100',
            'nip'   => 'required|string|max:100|unique:users',
            'jabatan'   => 'required|string|max:100',
            'organisasi'    => 'required|string|max:255',
            'unit_organisasi'   => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:255',
            'no_hp' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = \request()->except('_token');
        $data['opd_id'] = Auth::user()->opd->id;
        $data['password'] = bcrypt(request()->password);
        try {
            $this->user->store($data);
            Usercount();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
        return $this->success($data, 'Pegawai baru berhasil ditambahkan');
    }

    public function show($id)
    {
        if (\request()->ajax()) {
            $presensi = $this->presensi->Query();
            $data['table'] = $presensi->where('user_id', $id)->latest()->paginate();
            return view('oprator.presensi._data_presensi', $data);
        }

        $data['title'] = 'Detail data pegawai';
        $data['pegawai'] = $this->user->show($id);
        return view('oprator.users.show', $data);
    }

    public function update($id)
    {
        $user = $this->user->show($id);
        $validator = Validator::make(\request()->all(), [
            'nama'  => 'required|string|max:100',
            'nip'   => 'required|string|max:100|unique:users,nip,' . $user->id,
            'jabatan'   => 'required|string|max:100',
            'unit_organisasi'   => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $user->id,
            'password' => 'max:255',
            'no_hp' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = \request()->except('_token', '_method');
        $data['opd_id'] = $user->opd_id;
        if (\request()->password) {
            $data['password'] =  bcrypt(request()->password);
        } else {
            $data['password'] = $user->password;
        }

        try {
            $this->user->update($id, $data);
        } catch (\Throwable $th) {
            saveLogs($th->getMessage(), 'Error update profile user');
            return $this->error($th->getMessage());
        }
        return $this->success($data, 'Data pegawai berhasil diperbaharui');
    }
}
