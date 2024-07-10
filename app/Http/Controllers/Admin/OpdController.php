<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OpdService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OpdController extends Controller
{
    protected $opd;
    public function __construct(OpdService $opdService, UserService $userService)
    {
        $this->opd = $opdService;
        $this->user = $userService;
    }
    public function index()
    {
        if (request()->ajax()) {
            $opd = $this->opd->Query();
            if (\request()->search) {
                $opd->where('nama_opd', 'like', '%' . \request()->search . '%');
            }
            $data['table'] = $opd->paginate();
            return view('admin.opd._data_opd', $data);
        }
        $data['title'] = 'Admin OPD';
        return view('admin.opd.index');
    }

    public function create()
    {
        $data['title'] = 'Tambah data OPD';
        return view('admin.opd.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_opd' => 'required|string|max:100',
            'lat'      => 'required|string|max:50',
            'long'     => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = $request->except('_token');
        try {
            $this->opd->store($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
        return $this->success('OK', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $data['title'] = 'Detail OPD';
        $data['opd'] = $this->opd->show($id);
        $data['operator'] = $this->user->Query()->where('opd_id', $id)->where('role', 'oprator')->get();
        $data['pegawai'] = $this->user->Query()->where('opd_id', $id)->get();
        return view('admin.opd.show', $data);
    }

    public function update($id)
    {
        $validator = Validator::make(request()->all(), [
            'nama_opd'  => 'required|string|max:255',
            'lat'       => 'required|string|max:100',
            'long'       => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = request()->except('_token', '_method');
        try {
            $this->opd->update($id, $data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
        return $this->success($data, 'Data berhasil diperbaharui');
    }

    public function destroy($id)
    {
        $opd = $this->opd->find($id);
        $opd->delete();
        return $this->success('Data berhasil dihapus!');
    }
}
