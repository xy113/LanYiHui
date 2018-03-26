<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Feedback;

class FeedbackController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(){

        if ($this->isOnSubmit()) {
            $title = $this->request->post('title');
            $message = $this->request->post('message');
            Feedback::insert([
                'uid'=>$this->uid,
                'username'=>$this->username,
                'title'=>$title,
                'message'=>$message,
                'created_at'=>time(),
                'updated_at'=>time()
            ]);
            return ajaxReturn();
        }else{
            return $this->view('mobile.feedback');
        }
    }
}
