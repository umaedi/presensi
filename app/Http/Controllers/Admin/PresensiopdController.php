<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PresensiService;
use Illuminate\Http\Request;

class PresensiopdController extends Controller
{
    protected $presensi;
    public function __construct(PresensiService $presensiService)
    {
        $this->presensi = $presensiService;
    }
    public function show($id)
    {
        if (\request()->ajax()) {
            $data['table'] = $this->presensi->Query()->where('opd_id', $id)->with('user')->paginate();
            return view('admin.presensi._data_presensi_opd', $data);
        }
        $data['title'] = 'Presensi OPD';
        return view('admin.presensi.show', $data);
    }
}
