<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->assign([
            'tab'=>'home'
        ]);
    }
}
