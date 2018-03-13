<?php

namespace App\Http\Controllers\Post;

use App\Models\PostContent;
use App\Models\PostItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailController extends Controller
{
    /**
     *
     */
    public function index(Request $request, $aid=0){
        $this->appends(['aid'=>$aid]);

        PostItem::where('aid', $aid)->increment('view_num', 1);
        $article = PostItem::where('aid',$aid)->first()->toArray();
        $this->appends(['article'=>$article]);

        $content = PostContent::where('aid', $aid)->first()->toArray();
        $this->appends(['content'=>$content]);

        $this->appends(['hotnews'=>PostItem::where('status', 1)->orderBy('view_num', 'DESC')->limit(5)->get()]);

        return view('post.'.$article['type'], $this->data);
    }
}
