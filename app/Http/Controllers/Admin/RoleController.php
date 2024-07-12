<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;

class RoleController extends Controller
{
    public function index($id)
    {
        if(\request()->ajax()) {
            $user = User::where('id', \request()->userId)->first();
            return \view('admin.role._data_user', compact('user'));
        }

        $user = User::where('id', $id)->first();
        $opd_id = $user->opd->id;
        $data['title'] = 'Role pegawai';
        $data['user'] = $user;
        $data['user_opds'] = User::where('opd_id', $opd_id)->get();
        return \view('admin.role.index', $data);
    }

    public function setRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_operator_lama' => 'required|string|max:100',
            'id_operator_baru'      => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        DB::beginTransaction();
        try {
            User::where('id', $request->id_operator_lama)->update([
                'role' => 'user'
            ]);
            User::where('id', $request->id_operator_baru)->update([
                'role' => 'oprator'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack(); 
            throw $th;
        }
        DB::commit();
        return $this->success('OK', 'Role pegawai berhasil diubah');
    }
}
