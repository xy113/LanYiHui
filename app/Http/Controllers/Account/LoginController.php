<?php

namespace App\Http\Controllers\Account;

use App\Models\Member;
use App\Models\MemberStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LoginController extends BaseController
{

    /**
     *
     */
    public function index(){

        $this->assign([
            'redirect'=>$this->request->input('redirect')
        ]);

        return $this->view('account.login');
    }

    /**
     * 验证登录
     */
    public function check(Request $request){
        $account  = $request->post('account');
        $password = $request->post('password');

        $member = Member::where('username', $account)->orWhere('email', $account)->orWhere('mobile', $account)->first();
        if ($member) {
            if ($member->password == encrypt_password($password)){
                MemberStatus::where('uid', $member->uid)->update([
                    'lastvisit'=>time(),
                    'lastvisitip'=>getIp()
                ]);
                return ajaxReturn()->withCookie(Cookie::forever('uid', $member->uid))
                    ->withCookie(Cookie::forever('username', $member->username));
            }else {
                return ajaxError(1, trans('member.password incorrect'));
            }
        }else {
            return ajaxError(2, trans('member.account does not exist'));
        }
    }

    /**
     * AJAX login
     */
    public function ajaxlogin(){
        return $this->view('account.ajaxlogin');
    }
}
