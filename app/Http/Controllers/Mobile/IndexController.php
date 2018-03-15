<?php

namespace App\Http\Controllers\Mobile;

class IndexController extends BaseController
{
    public function index(){

        return view('mobile.index', $this->data);
    }
}
