<?php

namespace App\Http\Controllers\Mobile;

class FeedbackController extends BaseController
{
    public function index(){

        return $this->view('mobile.feedback');
    }
}
