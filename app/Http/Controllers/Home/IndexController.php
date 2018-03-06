<?php

namespace App\Http\Controllers\Home;

use App\Http\Helpers\VideoParser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        return view('home.index', ['title'=>'首页']);
    }
}
