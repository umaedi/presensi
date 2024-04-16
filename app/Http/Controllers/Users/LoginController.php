<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        Cache::put('web_token', $request->key, now()->addHour());
        $data['title'] = 'Login';
        return view('users.login.index', $data);
    }
}
