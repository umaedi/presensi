<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (\request()->ajax()) {
            $log = Log::query();
            $page = request('pagination', 15);
            $data['table'] = $log->latest()->paginate($page);
            return view('admin.log._data_log', $data);
        }
        return view('admin.log.index');
    }
}
