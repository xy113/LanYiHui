<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(function (Request $req, $next){
            if ($this->uid && $this->username) {
                return redirect()->action('Member\IndexController@index');
            }
            return $next($req);
        });
    }
}
