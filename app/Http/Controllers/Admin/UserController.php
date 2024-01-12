<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Services\PresensiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
        return view('admin.users.show', $data);
    }
}
