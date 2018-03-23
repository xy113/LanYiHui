<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Member;
use App\Models\MemberGroup;
use App\Models\MemberInfo;
use App\Models\MemberStat;
use App\Models\MemberStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class SignController extends Controller
{
    /**
     * SignController constructor.
     * @param Request $request
     */
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(function (Request $req, $next){
            if ($this->uid && $this->username) {
               return redirect()->to('/mobile/member');
            }
            return $next($req);
        });
    }

    /**
     *
     */
    public function signin(){

        if ($this->isOnSubmit()) {
            $account  = $this->request->post('account');
            $password = $this->request->post('password');

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
        }else {

            $this->assign([
                'redirect'=>$this->request->input('redirect')
            ]);
            return $this->view('mobile.login');
        }
    }

    /**
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function signup(){
        if ($this->isOnSubmit()) {
            $username = $this->request->post('username');
            $mobile   = $this->request->post('mobile');
            $password = $this->request->post('password');

            if (Member::where('username', $username)->exists()) {
                return ajaxError(1, trans('member.username be occupied'));
            }

            if (Member::where('mobile', $mobile)->exists()) {
                return ajaxError(2, trans('member.mobile be occupied'));
            }

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
        }else {
            $this->assign([
                'redirect'=>$this->request->input('redirect')
            ]);
            return $this->view('mobile.register');
        }
    }
}
