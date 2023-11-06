<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthOpd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $opd = auth()->guard('opd')->user();

        if (!$opd) {
            return redirect('/');
        }

        return $next($request);
    }
}
