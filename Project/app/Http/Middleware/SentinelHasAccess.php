<?php

namespace App\Http\Middleware;

use Closure;

class SentinelHasAccess
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
        $actions = $request->route()->getAction();

        if (array_key_exists('hasAccess', $actions))
        {
            $permissions = $actions['hasAccess'];
            $user = Sentinel::getUser();

            // Check hasAccess
            if ($user->hasAccess($permissions)) {
                return $next($request);
            }
            if ($request->ajax() || $request->wantsJson()) {
                return response('Không cho phép hành động !!!');
            }
            
            return redirect()->route('/')->with('error', 'Không có quyền truy cập !!!');
        }

        return $next($request);
    }
}
