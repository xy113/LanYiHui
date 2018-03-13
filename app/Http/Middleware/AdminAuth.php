<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class AdminAuth
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
        $adminid = $request->cookie('adminid');
        $username = $request->cookie('username');
        if (!$uid || !$username || !$adminid){
            return redirect()->action('Admin\LoginController@index');
        }

        if ($uid != $adminid) {
            return redirect()->action('Admin\LoginController@index')->withCookie(Cookie::forget('adminid'));
        }

        return $next($request);
    }
}
