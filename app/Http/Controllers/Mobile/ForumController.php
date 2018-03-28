<?php

namespace App\Http\Controllers\Mobile;

use App\Models\BlockItem;
use App\Models\ForumBoard;
use App\Models\ForumMessage;
use App\Models\ForumTopic;

class ForumController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $this->assign([
            'focus_imgs'=>BlockItem::where('block_id', 12)->get(),
            'boardlist'=>ForumBoard::where('visible', 1)->get(),
            'newtopics'=>ForumTopic::orderBy('tid','DESC')->limit(10)->get()
        ]);

        return $this->view('mobile.forum.index');
    }

    public function board($boardid) {

        ForumBoard::where('boardid', $boardid)->increment('views');
        $this->assign([
            'boardid'=>$boardid,
            'board'=>ForumBoard::where('boardid', $boardid)->first(),
            'topicCount'=>ForumTopic::where('boardid', $boardid)->count(),
            'messageCount'=>ForumMessage::where(['boardid' => $boardid, 'topic'=>0])->count(),
            'topiclist'=>ForumTopic::where('boardid', $boardid)->orderBy('tid', 'DESC')->paginate(10)
        ]);

        return $this->view('mobile.forum.board');
    }

    /**
     * @param $tid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function topic($tid){

        ForumTopic::where('tid', $tid)->increment('views');
        $topic = ForumTopic::where('tid', $tid)->first();
        $this->assign(['topic'=>$topic]);

        $message = ForumMessage::where(['tid'=>$tid, 'topic'=>1])->first();
        $this->assign(['message'=>$message]);

        $messagelist = ForumMessage::where(['tid'=>$tid, 'topic'=>0])->paginate(10);
        $this->assign(['messagelist'=>$messagelist]);

        $this->assign([
            'replyCount'=>ForumMessage::where(['tid'=>$tid, 'topic'=>0])->count()
        ]);

        return $this->view('mobile.forum.topic');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function publish(){

        if ($this->isOnSubmit()) {
            $title = $this->request->post('title');
            $message = $this->request->post('message');
            $boardid = $this->request->get('boardid');

            $tid = ForumTopic::insertGetId([
                'boardid'=>$boardid,
                'uid'=>$this->uid,
                'username'=>$this->username,
                'last_uid'=>$this->uid,
                'last_username'=>$this->username,
                'title'=>$title,
                'created_at'=>time()
            ]);

            ForumMessage::insert([
                'tid'=>$tid,
                'boardid'=>$boardid,
                'uid'=>$this->uid,
                'username'=>$this->username,
                'message'=>$message,
                'created_at'=>time(),
                'topic'=>1
            ]);

            return ajaxReturn(['tid'=>$tid]);
        }else {

            return $this->view('mobile.forum.publish');
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function reply(){
        $tid = $this->request->post('tid');
        $boardid = $this->request->post('boardid');
        $message = $this->request->post('message');

        $id = ForumMessage::insertGetId([
            'tid'=>$tid,
            'boardid'=>$boardid,
            'uid'=>$this->uid,
            'username'=>$this->username,
            'message'=>$message,
            'created_at'=>time(),
            'topic'=>0
        ]);

        ForumTopic::where('tid', $tid)->increment('replies');
        return ajaxReturn(['id'=>$id]);
    }
}
