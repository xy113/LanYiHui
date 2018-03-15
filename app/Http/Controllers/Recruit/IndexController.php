<?php

namespace App\Http\Controllers\Recruit;

class IndexController extends BaseController
{
    public function index(){
        return view('recruit.index', $this->data);
    }
}
