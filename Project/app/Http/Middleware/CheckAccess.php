<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Sentinel::check()) {
            if (!Sentinel::getUser()->hasAccess($role)) {
                return redirect()->route('index')
                                 ->with('error', 'Tài khoản của bạn, không đủ quyền hạn, để thực hiện thao tác này !');     
            }

            return $next($request);
        }

        return redirect()->route('index')
                         ->with('error', 'Bạn phải đăng nhập để thực hiện thao tác này !');
    }
}
