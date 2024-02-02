<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $staus = $this->middleware('guest');
    // }
    public function __invoke(Request $request)
    {
        $data['title'] = 'Login';
        return view('users.login.index', $data);
    }
}
