<?php

namespace App\Http\Controllers\Oprator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatuspegawaiController extends Controller
{
    public function index()
    {
        $data['title'] = 'Status Pegawai';
        return view('oprator.statuspegawai.index', $data);
    }
}
