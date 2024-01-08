<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Models\User;
use App\Services\OpdService;
use App\Services\UserService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $user;
    protected $opd;
    public function __construct(UserService $userService, OpdService $opdService)
    {
        $this->user = $userService;
        $this->opd = $opdService;
    }
    public function index()
    {
        $data['title'] = 'Dashboard Admin';
        $data['opd'] = Opd::count();
        $data['oprator'] = $this->user->Query()->where('role', 'oprator')->count();
        $data['users'] = User::count();
        return view('admin.dashboard.index', $data);
    }
}
