<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/10
 * Time: 下午3:18
 */

namespace App\WeChat\WxApi;


use App\Helpers\Http;

class WxUserApi extends WxApi
{
    /**
     * @param $openid
     * @return mixed
     * @throws \Exception
     */
    public function getInfo($openid){
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->getAccessToken()."&openid=$openid&lang=zh_CN";
        $res = Http::curlGet($url);
        return $res;
    }
}
