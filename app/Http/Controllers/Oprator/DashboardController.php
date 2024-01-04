<?php

namespace App\Http\Controllers\Oprator;

use App\Http\Controllers\Controller;
use App\Services\PresensiService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $user;
    protected $presensi;
    public function __construct(UserService $userService, PresensiService $presensiService)
    {
        $this->user = $userService;
        $this->presensi = $presensiService;
    }

    public function index()
    {
        if (\request()->ajax()) {
            $presensi = $this->presensi->Query();
            $data['table'] = $presensi->where('opd_id', Auth::user()->opd_id)->where('tanggal', date('Y-m-d'))->paginate();
            return view('oprator.presensi._data_presensi', $data);
        }
        $data['user'] =  $this->user->Query()->where('opd_id', Auth::user()->opd_id)->count();
        $data['presensi'] =  $this->presensi->Query()->where('opd_id', Auth::user()->opd_id)->where('tanggal', date('Y-m-d'))->count();
        $data['tanggal'] = Carbon::now('D MMMM Y');
        return view('oprator.dashboard.index', $data);
    }
}
