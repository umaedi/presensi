<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Services\ShiftService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    protected $shift;
    public function __construct(ShiftService $shiftService)
    {
        $this->shift = $shiftService;
    }
    public function index()
    {
        if (\request()->ajax()) {
            $data['table'] = $this->shift->Query()->where('opd_id', Auth::user()->opd_id)->get();
            return view('users.shift._data_table_shift', $data);
        }
        $data['title'] = 'Shift';
        return view('users.shift.index');
    }
}
