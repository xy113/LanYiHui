<?php

namespace App\Http\Controllers\Member;

use App\Models\ForumTopic;

class TopicController extends BaseController
{
    public function index(){

        if ($this->isOnSubmit()) {

        }else {

            $topics = ForumTopic::where('uid', $this->uid)->orderBy('tid', 'DESC')->paginate(20);
            $this->assign([
                'itemlist' => $topics,
                'pagination' => $topics->links(),
                'menu' => 'topic'
            ]);

            return $this->view('member.topic');
        }
    }
}
