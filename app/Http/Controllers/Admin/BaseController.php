<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $adminid = 0;
    protected $messageView = 'admin.message';

    /**
     * BaseController constructor.
     * @param Request $request
     */
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(function (Request $req, $next){
            $this->adminid = $req->cookie('adminid');
            return $next($req);
        });
    }
}
