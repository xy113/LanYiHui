<?php

namespace App\Http\Controllers\Account;

use App\Models\Member;
use App\Models\MemberGroup;
use App\Models\MemberInfo;
use App\Models\MemberStat;
use App\Models\MemberStatus;
use Illuminate\Support\Facades\Cookie;

class RegisterController extends BaseController
{
    public function index(){

        return view('account.register', $this->data);
    }

    public function save(){
        $username = $this->request->post('username');
        $mobile = $this->request->post('mobile');
        $password = $this->request->post('password');

        $group = MemberGroup::where('type', 'member')->first();
        $uid = Member::insertGetId([
            'gid'=>$group->gid,
            'username'=>$username,
            'mobile'=>$mobile,
            'password'=>encrypt_password($password)
        ]);

        MemberStatus::insert([
            'uid'=>$uid,
            'regdate'=>time(),
            'regip'=>$this->request->getClientIp(),
            'lastvisit'=>time(),
            'lastvisitip'=>$this->request->getClientIp(),
            'lastactive'=>time()
        ]);

        MemberInfo::insert(['uid'=>$uid]);
        MemberStat::insert(['uid'=>$uid]);

        return ajaxReturn(['uid'=>$uid])->cookie(Cookie::forever('uid', $uid))
            ->cookie(Cookie::forever('username', $username));
        //return $this->showSuccess(trans('member.register success'));

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(){
        $field = $this->request->input('field');
        $value = $this->request->input('value');

        if ($field === 'username'){
            $check = Member::where('username', $value)->count();
            if ($check) {
                return ajaxError(1, trans('member.username be occupied'));
            }
        }

        if ($field === 'mobile') {
            $check = Member::where('mobile', $value)->count();
            if ($check) {
                return ajaxError(1, trans('member.mobile be occupied'));
            }
        }

        return ajaxReturn();
    }
}
