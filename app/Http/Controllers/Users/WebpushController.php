<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebpushController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected $user;
    public function __construct(UserService $userService)
    {
        $this->user = $userService;
    }
    public function __invoke(Request $request)
    {
        $web_token = $request->web_token;
        $currentToken = Auth::user()->web_token;

        if ($currentToken) {
            if ($web_token !== $currentToken) {
                $user_id = Auth::user()->id;
                $data['web_token'] = $web_token;
                try {
                    $this->user->update($user_id, $data);
                } catch (\Throwable $th) {
                    return $this->error($th->getMessage());
                }

                return $this->success('OK', 'Web Token berhasil di update');
            } else {
                return $this->success($web_token, 'Web token sudah tersimpan di database!');
            }
        } else {
            $user_id = Auth::user()->id;
            $data['web_token'] = $web_token;
            try {
                $this->user->update($user_id, $data);
            } catch (\Throwable $th) {
                return $this->error($th->getMessage());
            }

            return $this->success($web_token, 'Web token berhasil disimpan');
        }
    }
}
