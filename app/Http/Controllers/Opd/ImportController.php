<?php

namespace App\Http\Controllers\Opd;

use Illuminate\Http\Request;
use App\Imports\PegawaiImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class ImportController extends Controller
{
    public function index()
    {
        return view('opd.pegawai.import');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new PegawaiImport(), $request->file('file'));

        return back();
        // $msg['success'] = true;
        // $msg['message'] = 'Profil Berhasil Diperbaharui!';
        // Session::flash('feedback', $msg);
        // return redirect('/opd/pegawai');
    }
}
