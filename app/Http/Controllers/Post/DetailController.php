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
        $data = [];
        $data['aid'] = $aid;

        PostItem::where('aid', $aid)->increment('view_num', 1);
        $article = PostItem::where('aid',$aid)->first()->toArray();
        $data['article'] = $article;

        $content = PostContent::where('aid', $aid)->first()->toArray();
        $data['content'] = $content;

        return view('post.'.$article['type'], $data);
    }
}
