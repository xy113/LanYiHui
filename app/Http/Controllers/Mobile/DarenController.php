<?php

namespace App\Http\Controllers\Mobile;

use App\Models\MemberArchive;

class DarenController extends BaseController
{
    public function index(){

        $this->assign([
            'itemlist'=>MemberArchive::where('status', 1)->limit(10)->orderBy('stars', 'DESC')->get()
        ]);
        return $this->view('mobile.daren');
    }
}
