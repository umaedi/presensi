<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PresensiopdController extends Controller
{
    public function show($id)
    {
        $data['title'] = 'Presensi OPD';
        return view('admin.presensi.show');
    }
}
