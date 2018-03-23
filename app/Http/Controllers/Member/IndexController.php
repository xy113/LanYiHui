<?php

namespace App\Http\Controllers\Member;

class IndexController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        return $this->view('member.index');
    }
}
