<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $userAgent = $request->header('User-Agent');
        if (strpos($userAgent, 'wv') !== false || (strpos($userAgent, 'iPhone') !== false && strpos($userAgent, 'Safari') !== false)) {
            return redirect('/user/dashboard');
        } else {
            return view('pages.notifikasi', [
                'title' => 'Notifikasi',
            ]);
        }
    }
}
