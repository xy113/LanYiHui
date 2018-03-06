<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $uid = 0;
    protected $username = '';

    /**
     * BaseController constructor.
     * @param Request $request
     */
    function __construct(Request $request)
    {
        parent::__construct($request);
    }
}
