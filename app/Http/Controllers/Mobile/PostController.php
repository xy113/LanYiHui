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
        $this->appends(['aid'=>$aid]);

        PostItem::where('aid', $aid)->increment('view_num', 1);
        $article = PostItem::where('aid',$aid)->first();
        $this->appends(['article'=>$article]);

        $content = PostContent::where('aid', $aid)->first();
        $this->appends(['content'=>$content]);

        $this->appends(['hotnews'=>PostItem::where('status', 1)->orderBy('view_num', 'DESC')->limit(5)->get()]);

        $commentList = PostComment::where('aid', $aid)->limit(5)->get();
        $this->appends([
            'commentList'=>$commentList,
            'commentCount'=>$commentList->count()
        ]);

        return view('mobile.'.$article['type'], $this->data);
    }

    public function itemlist(){
        $condition = [['status', '=', 1]];
        $catid = $this->request->input('catid');
        if ($catid) $condition[] = ['catid', '=', $catid];

        $itemlist = PostItem::where($condition)->orderBy('aid', 'DESC')->paginate(10);
        $this->appends([
            'catid'=>$catid,
            'itemlist'=>$itemlist
        ]);
        return view('mobile.post.list', $this->data);
    }
}
