<?php

namespace App\Http\Controllers\Post;

use App\Models\PostItem;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function index(){
        $condition = ['status'=>1];
        $catid = $this->request->input('catid');
        if ($catid) $condition['catid'] = $catid;
        $itemlist = PostItem::where($condition)->orderBy('aid', 'DESC')->paginate(10);
        $this->appends([
            'catid'=>$catid,
            'itemlist'=>$itemlist,
            'pagination'=>$itemlist->appends($catid ? ['catid'=>$catid] : [])->links(),
        ]);

        return view('post.index', $this->data);
    }
}
