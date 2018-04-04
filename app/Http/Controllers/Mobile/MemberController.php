<?php

namespace App\Http\Controllers\Mobile;

use App\Models\MemberArchive;
use Illuminate\Http\Request;

class MemberController extends BaseController
{
    public function index(){

        return $this->view('mobile.member.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archive(){

        $archive = MemberArchive::where('uid', $this->uid)->first();
        $this->assign([
            'archive'=>$archive,
            'verify_status'=>trans('member.verify_status')
        ]);

        return $this->view('mobile.member.archive');
    }
    public function edit(Request $request){
        if ($this->isOnSubmit()) {
            $user = $request->post('user');
            MemberArchive::where('uid', $this->uid)->update($user);
            return ajaxReturn();
        }else {
            $user = MemberArchive::where('uid', $this->uid)->first();
            $this->assign([
                'user'=>$user,
                'verify_status'=>trans('member.verify_status')
            ]);
            return $this->view('mobile.member.edit');
        }
    }
}
