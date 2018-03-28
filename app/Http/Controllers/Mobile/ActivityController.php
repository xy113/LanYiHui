<?php

namespace App\Http\Controllers\Mobile;

use App\Models\PostItem;

class ActivityController extends BaseController
{
    public function index(){

        $itemlist = PostItem::where(['catid'=>16, 'status'=>1])->paginate(10);

        $this->assign([
            'itemlist'=>$itemlist
        ]);

        return $this->view('mobile.activity');
    }
}
