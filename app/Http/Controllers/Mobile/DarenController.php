<?php

namespace App\Http\Controllers\Mobile;

use App\Models\MemberArchive;

class DarenController extends BaseController
{
    public function index(){

        $this->assign([
            'itemlist'=>MemberArchive::where('status', 1)->limit(10)->orderBy('stars', 'DESC')->get()
        ]);
        return $this->view('mobile.daren.index');
    }

    /**
     * @param $uid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($uid){

        MemberArchive::where('uid', $uid)->increment('views');
        $archive = MemberArchive::where('uid', $uid)->first();
        $this->assign(['archive'=>$archive]);

        return $this->view('mobile.daren.detail');
    }
}
