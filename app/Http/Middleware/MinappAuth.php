<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class MinappAuth
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
        $token = $request->header('X-Token');
        if ($token) {
            if (!Cache::get($token)) {
                return ajaxError(401, 'not loggedin');
            }
        } else {
            return ajaxError(401, 'not loggedin');
        }
        return $next($request);
    }
}
