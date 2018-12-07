<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class IsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Sentinel::check()) {
            return redirect()->route('index')
                             ->with('error', 'Bạn đã đăng nhập vào hệ thống rồi !');
        }

        return $next($request);
    }
}
