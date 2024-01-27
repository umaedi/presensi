<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\PresensiService;
use App\Http\Controllers\Controller;

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
            $data['table'] = $this->presensi->Query()->where('opd_id', $id)->whereDate('created_at', Carbon::now()->toDateString())->with('user')->paginate();
            return view('admin.presensi._data_presensi_opd', $data);
        }
        $data['title'] = 'Presensi OPD';
        return view('admin.presensi.show', $data);
    }
}
