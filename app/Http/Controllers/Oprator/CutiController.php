<?php

namespace App\Http\Controllers\Oprator;

use App\Http\Controllers\Controller;
use App\Services\IzinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CutiController extends Controller
{
    protected $cuti;
    public function __construct(IzinService $izinService)
    {
        $this->cuti = $izinService;
    }

    public function index()
    {
        if (\request()->ajax()) {
            $data['table'] = $this->cuti->Query()->where('opd_id', Auth::user()->opd_id)->paginate();
            return view('oprator.cuti._data_cuti', $data);
        }

        $data['title'] = 'Data cuti';
        return view('oprator.cuti.index', $data);
    }

    public function show($id)
    {
        $data['title'] = 'Detail cuti';
        $data['cuti'] = $this->cuti->find($id);
        return view('oprator.cuti.show', $data);
    }
}
