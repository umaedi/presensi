<?php

namespace App\Http\Controllers\Oprator;

use Carbon\Carbon;
use App\Models\Usercount;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\PresensiService;
use App\Http\Controllers\Controller;
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
            if (\request()->search) {
                $presensi->whereHas('user', function ($query) {
                    $query->where('nama', 'like', '%' . \request()->search . '%');
                });
            }
            $data['table'] = $presensi->where('opd_id', Auth::user()->opd_id)->whereDate('tanggal', Carbon::now()->toDateString())->paginate();
            return view('oprator.presensi._data_presensi', $data);
        }

        $totalUser = $this->user->Query()->where('opd_id', Auth::user()->opd_id)->count();
        $usersWithPresensi = $this->presensi->Query()->where('opd_id', Auth::user()->opd_id)->whereDate('created_at', Carbon::now()->toDateString())->distinct('user_id')->count('user_id');

        // Menghitung jumlah user yang belum melakukan presensi
        $usersWithoutPresensi = $totalUser - $usersWithPresensi;

        $data['user'] =  $this->user->Query()->where('opd_id', Auth::user()->opd_id)->count();
        $data['presensi'] =  $this->presensi->Query()->where('opd_id', Auth::user()->opd_id)->where('tanggal', date('Y-m-d'))->count();
        $data['tanggal'] = Carbon::now()->isoFormat('D MMMM Y');
        $data['sudahPresensi'] = $usersWithPresensi;
        $data['belumPresensi'] = $usersWithoutPresensi;
        return view('oprator.dashboard.index', $data);
    }
}
