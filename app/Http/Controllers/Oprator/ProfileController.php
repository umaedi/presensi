<?php

namespace App\Http\Controllers\Oprator;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\PresensiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected $user;
    protected $presensi;
    public function __construct(UserService $userService, PresensiService $presensiService)
    {
        $this->user = $userService;
        $this->presensi = $presensiService;
    }
    public function __invoke(Request $request)
    {
        $id = Auth::user()->id;
        if (\request()->ajax()) {
            $presensi = $this->presensi->Query();
            $data['table'] = $presensi->where('user_id', $id)->latest()->paginate();
            return view('oprator.presensi._data_presensi', $data);
        }

        $data['title'] = 'Detail data pegawai';
        $data['pegawai'] = $this->user->show($id);
        return view('oprator.users.show', $data);
    }
}
