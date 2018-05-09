<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Collection;
use App\Models\Member;
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
        if(Collection::where(['data_id'=>$aid,'uid'=>$this->uid,'data_type'=>'article'])->first()){
            $collect = 1;
        }else{
            $collect = 0;
        }
        $this->assign(['collect'=>$collect]);
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getjson(){
        $condition = [['status', '=', 1]];
        $catid = $this->request->input('catid');
        if ($catid) $condition[] = ['catid', '=', $catid];

        $itemlist = PostItem::where($condition)->orderBy('aid', 'DESC')->paginate(10)->map(function ($item){
            $item->image = image_url($item->image);
            $item->created_at = @date('Y-m-d H:i', $item->created_at);
            return $item;
        });
        return ajaxReturn($itemlist);
    }
    //留言  传入  id、message、reply_uid、reply_name
    public function message(){
        $req = $this->request->post();
        $msg = new PostComment;
        $user = Member::where('uid',$this->uid)->first();
        $msg['aid'] = $req['id'];
        $msg['uid'] = $this->uid;
        $msg['username'] = $user['username'];
        $msg['message'] = $req['message'];
        if($req['reply_uid']){
            $ruser = Member::where('uid',$req['reply_uid'])->first();
            $msg['reply_uid'] = $req['reply_uid'];
            $msg['reply_name'] = $ruser['username'];
        }else{
            $msg['reply_uid'] = 0;
            $msg['reply_name'] = '';
        }
        $msg['created_at'] = time();
        $msg->save();
        $post = PostItem::where('aid',$req['id'])->first();
        $post['comment_num'] = $post->comment()->count();
        $post->save();
        return ajaxReturn();
    }
}
