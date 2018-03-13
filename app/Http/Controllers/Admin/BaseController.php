<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class BaseController extends Controller
{
    protected $messageView = 'admin.message';
    protected $adminid = 0;

    /**
     * BaseController constructor.
     * @param Request $request
     */
    function __construct(Request $request)
    {
        parent::__construct($request);

        $this->middleware(function ($req, $next){
            $this->adminid = Cookie::get('adminid');
            $this->appends(['adminid'=>$this->adminid]);
            return $next($req);
        });
    }
}
