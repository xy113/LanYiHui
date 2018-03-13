<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;

class LogoutController extends Controller
{
    /**
     * @return $this
     */
    public function index(){
        return response()->redirectTo(URL::previous())
            ->withCookie(Cookie::forget('uid'))
            ->withCookie(Cookie::forget('username'))
            ->withCookie(Cookie::forget('adminid'));
    }
}
