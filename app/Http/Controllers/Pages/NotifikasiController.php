<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NotifikasiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        // return view('pages.maintenance', [
        //     'title' => 'Notifikasi',
        // ]);
        return view('pages.notifikasi', [
            'title' => 'Notifikasi',
        ]);
    }
}
