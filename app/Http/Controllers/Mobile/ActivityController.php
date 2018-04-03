<?php

namespace App\Http\Controllers\Mobile;

class ActivityController extends BaseController
{
    public function index(){

        return $this->view('mobile.activity');
    }
}
