<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(Request $request){
        return view('admin.admin');
    }

    public function wellcome(){
        return view('admin.wellcome');
    }
}
