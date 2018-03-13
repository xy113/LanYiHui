<?php

namespace App\Http\Controllers\Home;

use App\Models\BlockItem;
use App\Models\Member;
use App\Models\PostItem;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $this->appends([
            'focus_imgs'=>BlockItem::where('block_id', 10)->get(),
            'newslist'=>PostItem::where('status', 1)->limit(6)->orderBy('aid', 'DESC')->get(),
            'articleCount'=>PostItem::where('status', 1)->count(),
            'memberCount'=>Member::count()
        ]);

        return view('home.index', $this->data);
    }

}
