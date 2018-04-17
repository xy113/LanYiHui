<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Member;
use App\Models\MemberArchive;
use App\Models\MemberInfo;
use Illuminate\Http\Request;

class MemberController extends BaseController
{
    public function index(){

        $this->assign(['background'=>'url(../images/mobile/head-bg.jpg)','username'=>Member::find($this->uid)['username']]);
        return $this->view('mobile.member.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info(){
        if ($this->isOnSubmit()) {
            $req = $this->request->post('user');
            $memberinfo = MemberInfo::find($this->uid);
            $memberinfo['name'] = $req['fullname'];
            $memberinfo['sex'] = $req['sex'];
            $memberinfo['qq'] = $req['qq'];
            $memberinfo['birthday'] = $req['birthday'];
            $memberinfo['introduction'] = $req['introduction'];
            $memberinfo->save();
            $member = Member::find($this->uid);
            $member['username'] = $req['name'];
            $member['mobile'] = $req['phone'];
            $member['email'] = $req['email'];
            $member->save();
            return ajaxReturn();
        }else {
            $this->assign([
                'member'=>Member::find($this->uid)->toArray(),
                'user'=>MemberInfo::find($this->uid)->toArray(),
                'sex_items'=>trans('member.sex_items')
            ]);

            return $this->view('mobile.member.userinfo');
        }
    }
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
