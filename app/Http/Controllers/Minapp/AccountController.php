<?php

namespace App\Http\Controllers\Minapp;

use App\Helpers\Http;
use App\Models\Member;
use App\Models\MemberConnect;
use App\Models\MemberInfo;
use App\Models\MemberStatus;
use Illuminate\Support\Facades\Cache;

class AccountController extends BaseController
{
    public function signin()
    {
        $code = $this->request->input('code');
        $userInfo = $this->request->input('userInfo');
        $res = $this->getOpenid($code);
        if (isset($res['openid']) && isset($res['session_key'])) {
            $connect = MemberConnect::where('openid', $res['openid'])->first();
            if ($connect) {
                $user = Member::where('uid', $connect->uid)->first(['uid', 'username', 'email', 'mobile']);
                if ($user) {
                    Cache::forever($res['session_key'], $user->toArray());
                } else {
                    MemberConnect::where('openid', $res['openid'])->delete();
                    $this->addMember($userInfo, $res['openid'], $res['session_key']);
                }
            }else {
                $this->addMember($userInfo, $res['openid'], $res['session_key']);
            }
            return ajaxReturn(['token'=>$res['session_key']]);
        }else {
            return ajaxError($res['errcode'], $res['errmsg']);
        }
    }

    private function addMember($userInfo, $openid, $token) {
        $uid = Member::insertGetId(['username'=>$userInfo['nickName']]);
        MemberConnect::insert([
            'uid'=>$uid,
            'openid'=>$openid,
            'platform'=>'minapp',
            'nickname'=>$userInfo['nickName'],
            'sex'=>$userInfo['gender'],
            'province'=>$userInfo['province'],
            'city'=>$userInfo['city'],
            'country'=>$userInfo['country'],
            'headimgurl'=>$userInfo['avatarUrl'],
            'created_at'=>time()
        ]);

        MemberInfo::insert([
            'uid'=>$uid,
            'sex'=>$userInfo['gender'],
            'province'=>$userInfo['province'],
            'city'=>$userInfo['city'],
            'country'=>$userInfo['country'],
        ]);

        MemberStatus::insert([
            'uid'=>$uid,
            'regdate'=>time(),
            'regip'=>$this->request->ip()
        ]);

        Cache::forever($token, [
            'uid'=>$uid,
            'username'=>$userInfo['nickName'],
            'mobile'=>'',
            'email'=>''
        ]);

        return $uid;
    }

    /**
     * @param $code
     * @return mixed
     */
    private function getOpenid($code)
    {
        $appid = config('minapp.appid');
        $secret = config('minapp.secret');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret";
        $url.= "&js_code=$code&grant_type=authorization_code";
        return json_decode(Http::curlGet($url), true);
    }
}
