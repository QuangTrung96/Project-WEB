<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelInRole
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

        if (array_key_exists('inRole', $actions)) {
            $roles = $actions['inRole'];

            if (is_array($roles) || is_object($roles)) {
                foreach ($roles as $r) {
                    if($this->checkRole($r)) {
                        return $next($request);
                    }
                }
            } else {
                if ($this->checkRole($roles)) {
                    return $next($request);
                }
            }

            return redirect()->route('index')->with('error', 'Bạn không có quyền thực hiện hành động này !!!');
        }

        return $next($request);
    }
}
