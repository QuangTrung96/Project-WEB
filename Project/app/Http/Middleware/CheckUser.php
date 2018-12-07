<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class CheckUser
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
        if (!Sentinel::check()) {
            return redirect()->route('index')
                             ->with('error', 'Bạn phải đăng nhập để thực hiện thao tác này !');
        }

        return $next($request);
    }
}
