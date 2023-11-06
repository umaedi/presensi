<?php

namespace App\Http\Controllers\Opd;

use App\Models\Cuty;
use App\Models\Absent;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Opd;
use Illuminate\Support\Facades\Session;

class PegawaiController extends Controller
{
    public function index()
    {
        $opd = auth()->guard('opd')->user();
        if (\request()->ajax()) {
            $pegawai = Pegawai::query();

            $page = request()->get('paginate', 10);

            if (\request('search')) {
                $pegawai->where('name', 'like', '%' . request('search') . '%');
            }

            $data['table'] = $pegawai->where('opd_id', $opd->id)->where('role', 1)->paginate($page);

            return view('opd.pegawai._data_table_pegawai', $data);
        }
        $data['title'] = 'Data Pegawai';
        return view('opd.pegawai.index', $data);
    }

    public function show($id)
    {
        $opd = auth()->guard('opd')->user();

        if (\request()->ajax()) {

            $data['table'] = Absent::where('opd_id', $opd->id)->where('pegawai_id', $id)->limit(5)->latest()->get();

            return view('opd.pegawai._data_table_persensi', $data);
        }

        $data['pegawai'] = Pegawai::where('opd_id', $opd->id)->where('id', $id)->first();
        $data['hadir'] = Absent::where('opd_id', $opd->id)->where('pegawai_id', $id)->count();
        $data['telat'] = Absent::where('opd_id', $opd->id)->where('pegawai_id', $id)->where('status', 2)->count();
        $data['izin'] = Cuty::where('opd_id', $opd->id)->where('pegawai_id', $id)->count();
        $data['title'] = 'Detail Data Diri Pegawai';

        return view('opd.pegawai.show', $data);
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::where('opd_id', auth()->guard('opd')->user()->id)->where('id', $id)->first();
        $pegawai->update([
            'nip'       => $request->nip,
            'name'      => $request->name,
            'email'     => $request->email,
            'no_tlp'    => $request->no_tlp,
            'password'  => $request->password ? $request->password : $pegawai->password,
        ]);

        $msg['success'] = true;
        $msg['message'] = 'Profil Berhasil Diperbaharui!';
        Session::flash('feedback', $msg);
        return back();
    }

    public function create()
    {
        $data['opds'] = Opd::all();
        $data['title'] = 'Tambah Pegawai';
        return view('opd.pegawai.create', $data);
    }

    public function store(Request $request)
    {
        Pegawai::create($request->except('_token'));
        $msg['success'] = true;
        $msg['message'] = 'Data Pegawai Berhasil Di Simpan!';
        Session::flash('feedback', $msg);
        return back();
    }
}
