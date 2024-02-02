<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Models\User;
use App\Services\PresensicountService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $user;
    protected $presensiCount;
    public function __construct(UserService $userService, PresensicountService $presensicountService)
    {
        $this->user = $userService;
        $this->presensiCount = $presensicountService;
    }
    public function index(Request $request)
    {
        if (\request()->ajax()) {
            $data['table'] = $this->presensiCount
                ->Query()
                ->whereDate('updated_at', Carbon::now()->toDateString())
                ->with('opd')
                ->orderByRaw('(total_presensi / total_user)' . $request->rank . ', total_presensi ' .  $request->rank)
                ->paginate();
            return view('admin.dashboard._data_presensi_count', $data);
        }
        $data['title'] = 'Dashboard Admin';
        $data['opd'] = Opd::count();
        $data['oprator'] = $this->user->Query()->where('role', 'oprator')->count();
        $data['users'] = User::count();
        return view('admin.dashboard.index', $data);
    }
}
