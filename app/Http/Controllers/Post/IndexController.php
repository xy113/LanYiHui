<?php

namespace App\Http\Controllers\Post;

use App\Models\PostItem;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    /**
     *
     */
    public function index(){

        $condition = ['status'=>1];
        $catid = $this->request->input('catid');
        if ($catid) $condition['catid'] = $catid;
        $itemlist = PostItem::where($condition)->orderBy('aid', 'DESC')->paginate(10);
        $this->assign([
            'catid'=>$catid,
            'itemlist'=>$itemlist,
            'pagination'=>$itemlist->appends($catid ? ['catid'=>$catid] : [])->links(),
        ]);

        return $this->view('post.index');
    }
}
