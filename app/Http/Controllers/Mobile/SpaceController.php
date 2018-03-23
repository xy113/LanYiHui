<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Member;
use App\Models\MemberArchive;

class SpaceController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($uid){

        $this->assign([
            'member'=>Member::where('uid', $uid)->first(),
            'archive'=>MemberArchive::where('uid', $uid)->first()
        ]);

        return $this->view('mobile.space');
    }
}
