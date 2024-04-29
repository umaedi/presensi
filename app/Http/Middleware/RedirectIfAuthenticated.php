<?php

namespace App\Http\Middleware;

use App\Models\Webview;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // if (!isset($request->webview)) {
        //     $user = Auth::user();
        //     if ($user) {
        //         $data = [
        //             'nip'   => $user->nip,
        //             'nama'  => $user->nama,
        //             'opd'   => $user->opd->nama_opd,
        //             'jabatan'   => $user->jabatan,
        //         ];
        //         Webview::create($data);
        //     }
        // }

        Cache::put($request->email, $request->key, now()->addDays(90));

        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
