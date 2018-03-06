<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;

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
        //echo 'uid:'.$uid.',username:'.$username;exit();
        if (!$uid || !$username || !$adminid){
            return redirect()->route('login');
        }

        if ($uid !== $adminid) {
            cookie('adminid', null);
            return redirect()->route('login');
        }

        return $next($request);
    }
}
