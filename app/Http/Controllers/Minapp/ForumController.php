<?php

namespace App\Http\Controllers\Minapp;

use App\Models\ForumBoard;
use App\Models\ForumMessage;
use App\Models\ForumTopic;

class ForumController extends BaseController
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_board()
    {
        $boardid = $this->request->input('boardid');
        $board = ForumBoard::where('boardid', $boardid)->first();
        $board->icon = image_url($board->icon);
        $board->topics = ForumTopic::where('boardid', $boardid)->count();
        $board->replies = ForumMessage::where('boardid', $boardid)->count();

        return ajaxReturn(['board'=>$board]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchget_board()
    {
        $items = ForumBoard::orderBy('displayorder')->get()->map(function ($item){
            $item->icon = image_url($item->icon);
            return $item;
        });

        return ajaxReturn(['items'=>$items]);
    }

    public function add_topic()
    {
        $boardid = $this->request->input('boardid');
        $title   = $this->request->input('title');
        $message = $this->request->input('message');

        $tid = ForumTopic::insertGetId([
            'boardid'=>$boardid,
            'uid'=>$this->uid,
            'username'=>$this->username,
            'last_uid'=>$this->uid,
            'last_username'=>$this->username,
            'title'=>$title,
            'created_at'=>time()
        ]);

        ForumMessage::insertGetId([
            'tid'=>$tid,
            'boardid'=>$boardid,
            'uid'=>$this->uid,
            'username'=>$this->username,
            'message'=>$message,
            'created_at'=>time(),
            'topic'=>1
        ]);

        return ajaxReturn(['tid'=>$tid]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_topic()
    {
        $tid = $this->request->input('tid');
        $topic = ForumTopic::where('tid', $tid)->first();
        $topic->avatar = avatar($topic->uid);

        $board = ForumBoard::where('boardid', $topic->boardid)->first();
        $board->icon = image_url($board->icon);

        $message = ForumMessage::where('tid', $tid)->where('topic', 1)->first();

        return ajaxReturn([
            'topic'=>$topic,
            'board'=>$board,
            'message'=>$message
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchget_topic()
    {
        $offset = intval($this->request->input('offset'));
        $count = intval($this->request->input('count'));
        !$count && $count = 20;

        $condition = [];
        $boardid = $this->request->input('boardid');
        if ($boardid) $condition['boardid'] = $boardid;

        $orderby = $this->request->input('orderby');
        if ($orderby === 'replies-desc') {
            $sortby = 'replies';
        }else {
            $sortby = 'tid';
        }

        $items = ForumTopic::where($condition)->offset($offset)->limit($count)->orderByDesc($sortby)
            ->get()->map(function ($topic) {
                $topic->avatar = avatar($topic->uid);
                $topic->last_avatar = avatar($topic->last_uid);
                return $topic;
            });

        return ajaxReturn([
            'items'=>$items
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_message()
    {
        $id = $this->request->input('id');
        $message = ForumMessage::where('id', $id)->first();
        $message->avatar = avatar($message->uid);

        return ajaxReturn([
            'message'=>$message
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchget_message()
    {
        $offset = intval($this->request->input('offset'));
        $count = intval($this->request->input('count'));
        !$count && $count = 20;

        $tid = $this->request->input('tid');
        $items = ForumMessage::where('tid', $tid)->where('topic', 0)->offset($offset)->limit($count)
            ->get()->map(function ($item){
            $item->avatar = avatar($item->uid);
            return $item;
        });

        return ajaxReturn([
            'items'=>$items
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function reply()
    {
        $tid = $this->request->input('tid');
        $boardid = $this->request->input('boardid');
        $message = $this->request->input('message');

        $id = ForumMessage::insertGetId([
            'tid'=>$tid,
            'boardid'=>$boardid,
            'uid'=>$this->uid,
            'username'=>$this->username,
            'message'=>$message,
            'created_at'=>time()
        ]);

        return ajaxReturn(['id'=>$id]);
    }
}
