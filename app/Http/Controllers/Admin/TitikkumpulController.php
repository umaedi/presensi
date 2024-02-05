<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TitikkumpulService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TitikkumpulController extends Controller
{
    protected $titikkumpul;
    public function __construct(TitikkumpulService $titikkumpulService)
    {
        $this->titikkumpul = $titikkumpulService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $titikkumpul = $this->titikkumpul->Query();

            if (\request()->search) {
                $titikkumpul->where('nama_lokasi', 'like', '%' . \request()->search . '%');
            }

            $data['table'] = $titikkumpul->paginate();
            return view('admin.titikkumpul._data_table', $data);
        }

        $data['title'] = 'Titik Kumpul';
        return view('admin.titikkumpul.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Titik Kumpul';
        return view('admin.titikkumpul.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lokasi'   => 'required|string|max:255',
            'lat'           => 'required|max:100',
            'long'          => 'required|max:100'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = $request->except('_token');
        try {
            $this->titikkumpul->store($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }

        return $this->success('OK', 'Titik Lokasi Kumpul Berhasil Ditambahkan');
    }

    public function show($id)
    {
        $data['title'] = 'Detail Lokasi Titik Kumpul';
        $data['titiklokasi'] = $this->titikkumpul->find($id);
        return view('admin.titikkumpul.show', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_lokasi'   => 'required|string|max:255',
            'lat'           => 'required|max:100',
            'long'          => 'required|max:100'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $data = $request->except('_token', '_method');
        try {
            $this->titikkumpul->update($id, $data);
        } catch (\Throwable $th) {
            saveLogs($th->getMessage(), 'Error ketika update titik kumpul!', 'erorr');
            return $this->error($th->getMessage());
        }

        return $this->success('OK', 'Titik Kumpul berhasil diperbaharui');
    }

    public function updateStatus(Request $request, $id)
    {
        $dataCheck = $this->titikkumpul->find($id);
        if ($dataCheck['status'] == "false") {
            $data['status'] = "true";
        } else {
            $data['status'] = "false";
        }
        try {
            $this->titikkumpul->update($id, $data);
        } catch (\Throwable $th) {
            saveLogs($th->getMessage(), 'Error ketika update titik kumpul!', 'erorr');
            return $this->error($th->getMessage());
        }

        return $this->success('OK', 'Status Titik Kumpul berhasil diperbaharui');
    }
}
