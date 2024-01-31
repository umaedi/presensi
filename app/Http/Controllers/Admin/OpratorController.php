<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OpdService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OpratorController extends Controller
{
    protected $opd;
    protected $user;
    public function __construct(OpdService $opdService, UserService $userService)
    {
        $this->opd = $opdService;
        $this->user = $userService;
    }
    public function index()
    {
        if (request()->ajax()) {
            $user = $this->user->Query();
            if (request()->search) {
                $user->where('nama', 'like', '%' . \request()->search . '%')->orWhere('nip', \request()->search);
            }
            $data['table'] = $user->where('role', 'oprator')->paginate();
            return view('admin.oprator._data_oprator', $data);
        }
        $data['title'] = 'Data Oprator OPD';
        $data['opds']    = $this->opd->Query()->whereNotNull('lat')->whereNotNull('long')->get();
        return view('admin.oprator.index', $data);
    }
    public function store()
    {
        $validator = Validator::make(\request()->all(), [
            'nama'  => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:255',
            'opd_id'    => 'required|string|max:2',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = \request()->except('_token');
        $data['nip'] = '-';
        $data['jabatan'] = '-';
        $data['unit_organisasi'] = '-';
        $data['no_hp'] = '-';
        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'oprator';

        try {
            $this->user->store($data);
        } catch (\Throwable $th) {
            saveLogs($th->getMessage(), 'error menambah oprator');
            return $this->error($th->getMessage());
        }
        return $this->success($data, 'Berhasil menambah oprator');
    }
}
