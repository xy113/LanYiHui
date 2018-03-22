<?php

namespace App\Http\Controllers\Admin;

use Cookie;
use App\Models\Member;
use Illuminate\Http\Request;

class LoginController extends BaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(){

        if ($this->request->cookie('adminid')) {
            return redirect()->to('/admin');
        }else {
            return view('admin.login', $this->data);
        }
    }

    /**
     * 验证登录
     */
    public function checklogin(){
        $account  = $this->request->post('account');
        $password = $this->request->post('password');

        $member = Member::where('username',$account)->orWhere('mobile',$account)->orWhere('email',$account)->first();
        if (!$member->admincp){
            return ajaxError(1, trans('member.you are not an administrator'));
        }

        if ($member->password !== encrypt_password($password)){
            return ajaxError(2, trans('member.password incorrect'));
        }

        $uidCookie = Cookie::make('uid', $member->uid);
        $adminidCookie = Cookie::make('adminid', $member->uid);
        $usernameCookie = Cookie::make('username', $member->username);

        return ajaxReturn(['uid'=>$member->uid, 'username'=>$member->username])
            ->cookie($uidCookie)->cookie($adminidCookie)->cookie($usernameCookie);
    }

    /**
     * 退出登录
     */
    public function logout(){
        $cookie = Cookie::forget('adminid');
        return response()->redirectToRoute('login')->withCookie($cookie);
    }
}
