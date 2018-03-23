<?php

namespace App\Http\Controllers\Mobile;

class MemberController extends BaseController
{
    public function index(){

        return $this->view('mobile.member.index');
    }
}
