<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OpdService;
use App\Services\SubOpdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubOpdController extends Controller
{
    protected $subopd;
    protected $opd;
    public function __construct(SubOpdService $subOpdService, OpdService $opdService)
    {
        $this->subopd = $subOpdService;
        $this->opd = $opdService;
    }

    public function index()
    {
        if (request()->ajax()) {
            $subopd = $this->subopd->Query();
            if (\request()->search) {
                $subopd->where('nama_opd', 'like', '%' . \request()->search . '%');
            }
            $data['table'] = $subopd->paginate();
            return view('admin.subopd._data_opd', $data);
        }
        return view('admin.subopd.index');
    }

    public function create()
    {
        $data['title'] = 'Tambah data Sub OPD';
        $data['opd'] = $this->opd->getAll();
        return view('admin.subopd.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_sub_opd' => 'required|string|max:100',
            'lat'      => 'required|string|max:50',
            'long'     => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = $request->except('_token');
        try {
            $this->subopd->store($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
        return $this->success('OK', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $data['title'] = 'Detail OPD';
        $data['subopd'] = $this->subopd->show($id);
        $data['opd'] = $this->opd->getAll();
        return view('admin.subopd.show', $data);
    }

    public function update($id)
    {
        $validator = Validator::make(request()->all(), [
            'nama_sub_opd'  => 'required|string|max:255',
            'lat'       => 'required|string|max:100',
            'long'       => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = request()->except('_token', '_method');
        try {
            $this->subopd->update($id, $data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
        return $this->success($data, 'Data berhasil diperbaharui');
    }

    public function destroy($id)
    {
        $subopd = $this->subopd->find($id);
        $subopd->delete();
        return $this->success('Data berhasil dihapus!');
    }
}
