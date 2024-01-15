<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportuserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_excel' => 'required|mimes:csv,xls,xlsx'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        Excel::import(new UsersImport(), $request->file('file_excel'));

        return $this->success('OK', 'Data berhasil ditambahkan');
    }
}
