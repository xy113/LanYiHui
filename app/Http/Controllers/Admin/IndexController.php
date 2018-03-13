<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request){
        return view('admin.admin');
    }

    public function wellcome(){
        return view('admin.wellcome');
    }
}
