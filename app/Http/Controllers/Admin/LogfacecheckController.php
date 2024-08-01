<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logfacecheck;

class LogfacecheckController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data['table'] = Logfacecheck::latest()->paginate();
            return view('admin.face._data_table', $data);
        };

        $data['title'] = "Log type face check";
        return view('admin.face.index', $data);
    }

    public function show($id)
    {
        $data['title'] = "Detail log face check";
        $data['user'] = Logfacecheck::find($id);
        return view('admin.face.show', $data);
    }
}
