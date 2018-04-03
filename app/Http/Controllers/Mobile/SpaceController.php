<?php

namespace App\Http\Controllers\Mobile;

use App\Models\ForumTopic;
use App\Models\MemberArchive;
use App\Models\PostItem;

class SpaceController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($uid){

        MemberArchive::where('uid', $uid)->increment('views');
        $this->assign([
            'uid'=>$uid,
            'archive'=>MemberArchive::where('uid', $uid)->first(),
            'articlelist'=>PostItem::where(['uid'=>$uid, 'status'=>1])->limit(5)->orderByDesc('aid')->get(),
            'topiclist'=>ForumTopic::where('uid', $uid)->limit(5)->orderByDesc('tid')->get()
        ]);

        return $this->view('mobile.space');
    }
}
