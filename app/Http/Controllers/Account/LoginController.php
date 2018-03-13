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
    public function index(Request $request){
        $data = [
            'redirect'=>$request->input('redirect')
        ];

        return view('account.login', $data);
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
        return view('account.ajaxlogin');
    }

    /**
     *
     */
    public function qrcode(){
        $login_code = cookie('login_code');
        if (!$login_code) {
            $login_code = md5(time().random(10));
            M('scan_login')->insert(array(
                'uid'=>0,
                'login_code'=>$login_code,
                'scaned'=>0,
                'create_time'=>time()
            ));
            cookie('login_code', $login_code);
        }
        $url = "cgapp://scanLogin?login_code=".$login_code;
        include LIB_PATH.'Vendor/phpqrcode.php';
        \QRcode::png($url, false, QR_ECLEVEL_H, 10);
    }

    /**
     *
     */
    public function scan(){
        $login_code = cookie('login_code');
        $check = M('scan_login')->where(array('login_code'=>$login_code, 'scaned'=>1))->getOne();
        if ($check) {
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'not scaned');
        }
    }

    /**
     *
     */
    public function confirm(){
        $login_code = cookie('login_code');
        $check = M('scan_login')->where(array('login_code'=>$login_code, 'scaned'=>1))->getOne();
        if ($check) {
            $member = (new MemberModel())->where(array('uid'=>$check['uid']))->getOne();
            cookie('login_code', null);
            cookie('uid', $member['uid']);
            cookie('username', $member['username']);
            (new MemberStatusModel())->where(array('uid'=>$check['uid']))->data(array('lastvisit'=>TIMESTAMP, 'lastvisitip'=>getIp()))->save();
            M('scan_login')->where(array('login_code'=>$login_code))->delete();
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'not scaned');
        }
    }
}
