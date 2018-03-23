<?php

namespace App\Http\Controllers\Join;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    function __construct(Request $request)
    {
        parent::__construct($request);
    }
}
