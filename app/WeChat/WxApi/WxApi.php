<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/10
 * Time: 下午2:09
 */

namespace App\WeChat\WxApi;


use App\Helpers\Http;
use Illuminate\Support\Facades\Cache;

class WxApi
{
    public $appid = '';
    public $appsecret = '';

    /**
     * WxApi constructor.
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    function __construct()
    {
        $this->appid = setting('wx.appid');
        $this->appsecret = setting('wx.appsecret');
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function getAccessToken(){
        try {
            $data = Cache::get('weixin_access_token');
            if ($data && $data['expires_time'] > time()){
                return $data['access_token'];
            }else {
                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret;
                $res = Http::curlGet($url);
                $data = json_decode($res, true);
                if ($data['access_token']) {
                    $data['expires_time'] = time()+7000;
                    $data['create_time'] = date('Y-m-d H:i:s');
                    Cache::forever('weixin_access_token', $data);
                    return $data['access_token'];
                }else {
                    return false;
                }
            }
        }catch (\InvalidArgumentException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function getJsApiTicket(){
        try {
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $data = Cache::get('weixin_jsapi_ticket');
            if ($data && $data['expire_time'] > time()){
                return $data['ticket'];
            }else {
                $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=".$this->getAccessToken();
                $res = Http::curlGet($url);
                $data = json_decode($res, true);
                if ($data['ticket']){
                    $data['expires_time'] = time()+7000;
                    $data['create_time'] = date('Y-m-d H:i:s');
                    Cache::forever('weixin_jsapi_ticket', $data);
                    return $data['ticket'];
                }else {
                    return false;
                }
            }
        }catch (\InvalidArgumentException $e) {
            return $e->getMessage();
        }
    }
}
