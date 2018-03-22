<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class MobileMemberAuth
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
        $uid = $request->cookie('uid');
        $username = $request->cookie('username');
        if (!$uid || !$username) {
            return redirect()->action('Mobile\SignController@signin', ['redirect' => URL::full()]);
        }
        return $next($request);
    }
}
