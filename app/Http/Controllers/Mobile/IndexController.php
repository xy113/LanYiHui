<?php

namespace App\Http\Controllers\Mobile;

use App\Models\BlockItem;
use App\Models\PostItem;

class IndexController extends BaseController
{
    public function index(){

        $this->assign([
            'focus_imgs'=>BlockItem::where('block_id', 10)->get(),
            'newslist'=>PostItem::where(['status'=>1,'catid'=>15])->orderBy('aid', 'DESC')->limit(5)->get()
        ]);

        return $this->view('mobile.index');
    }
}
