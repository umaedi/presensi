<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Services\OpdService;
use App\Services\PresensiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user;
    protected $presensi;
    protected $opd;
    public function __construct(UserService $userService, PresensiService $presensiService, OpdService $opdService)
    {
        $this->user = $userService;
        $this->presensi = $presensiService;
        $this->opd = $opdService;
    }

    public function index()
    {
        if (\request()->ajax()) {
            $user = $this->user->Query();
            if (request()->search) {
                $user->where('nama', 'like', '%' . \request()->search . '%');
            }
            $data['table'] = $user->with('opd')->paginate();
            return view('admin.users._data_user', $data);
        }
        return view('admin.users.index');
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
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
        return $this->success($data, 'Pegawai baru berhasil ditambahkan');
    }

    public function show($id)
    {
        if (\request()->ajax()) {
            $presensi = $this->presensi->Query();
            $data['table'] = $presensi->where('user_id', $id)->paginate();
            return view('oprator.presensi._data_presensi', $data);
        }
        $data['title'] = 'Detail Pegawai';
        $data['pegawai'] = $this->user->show($id);
        $data['opds']   = $this->opd->getAll();
        return view('admin.users.show', $data);
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

    public function destroy($id)
    {
        try {
            $this->user->destroy($id);
        } catch (\Throwable $th) {
            throw $th;
        }

        $presensi = $this->presensi->find($id);
        if ($presensi) {
            $presensi->destroy();
        }

        return redirect('/admin/pegawai')->with('msg_delete', 'Pegawai berhasil dihapus');
    }
}
