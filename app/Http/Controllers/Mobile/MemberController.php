<?php

namespace App\Http\Controllers\Mobile;

class MemberController extends BaseController
{
    public function index(){

        return view('mobile.member.index', $this->data);
    }
}
