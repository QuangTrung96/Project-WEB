<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

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

        if (array_key_exists('hasAccess', $actions)) {

            $permissions = $actions['hasAccess'];
            $user = Sentinel::getUser();

            // Check hasAccess
            if ($user->hasAccess($permissions)) {
                return $next($request);
            }
            if ($request->ajax() || $request->wantsJson()) {
                return response('Bạn không có quyền thực hiện hành động này !!!');
            }
            
            return redirect()->route('index')->with('error', 'Bạn không có quyền thực hiện hành động này !!!');
        }

        return $next($request);
    }
}
