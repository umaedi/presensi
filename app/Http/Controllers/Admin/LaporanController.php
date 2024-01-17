<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            dd('ok');
        }
        $data['title'] = 'Laporan presensi pegawai';
        return view('admin.laporan.index', $data);
    }
}
