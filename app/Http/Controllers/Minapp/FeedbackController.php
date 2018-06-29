<?php

namespace App\Http\Controllers\Minapp;

use App\Models\Feedback;

class FeedbackController extends BaseController
{
    public function index(){

        $title = $this->request->input('title');
        $message = $this->request->input('message');

        $id = Feedback::insertGetId([
            'uid'=>$this->uid,
            'username'=>$this->username,
            'title'=>$title,
            'message'=>$message,
            'created_at'=>time(),
            'updated_at'=>time()
        ]);

        return ajaxReturn(['id'=>$id]);
    }
}
