<?php

namespace App\Http\Controllers\Mobile;

use App\Models\PostComment;
use App\Models\PostContent;
use App\Models\PostItem;

class PostController extends BaseController
{
    public function index(){

    }

    public function detail($aid){
        $this->assign(['aid'=>$aid]);

        PostItem::where('aid', $aid)->increment('view_num', 1);
        $article = PostItem::where('aid',$aid)->first();
        $this->assign(['article'=>$article]);

        $content = PostContent::where('aid', $aid)->first();
        $this->assign(['content'=>$content]);

        $this->assign(['hotnews'=>PostItem::where('status', 1)->orderBy('view_num', 'DESC')->limit(5)->get()]);

        $commentList = PostComment::where('aid', $aid)->limit(5)->get();
        $this->assign([
            'commentList'=>$commentList,
            'commentCount'=>$commentList->count()
        ]);

        return $this->view('mobile.'.$article['type']);
    }

    public function itemlist(){
        $condition = [['status', '=', 1]];
        $catid = $this->request->input('catid');
        if ($catid) $condition[] = ['catid', '=', $catid];

        $itemlist = PostItem::where($condition)->orderBy('aid', 'DESC')->paginate(10);
        $this->assign([
            'catid'=>$catid,
            'itemlist'=>$itemlist
        ]);
        return $this->view('mobile.post.list');
    }
}
