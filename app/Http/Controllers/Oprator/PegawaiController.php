<?php

namespace App\Http\Controllers\Oprator;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    protected $user;
    public function __construct(UserService $userService)
    {
        $this->user = $userService;
    }

    public function index()
    {
        if (\request()->ajax()) {
            $data['table'] = $this->user->Query()->where('opd_id', Auth::user()->opd_id)->paginate();
            return view('oprator.users._data_user', $data);
        }
        return view('oprator.users.index');
    }

    public function store()
    {
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
}
