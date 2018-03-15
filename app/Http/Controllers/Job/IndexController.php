<?php

namespace App\Http\Controllers\Job;


class IndexController extends BaseController
{
    public function index(){

        return view('job.index', $this->data);
    }
}
