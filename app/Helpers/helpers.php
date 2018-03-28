<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/2/28
 * Time: 下午4:46
 */

use App\Models\Settings;

/**
 * 后台配置操作函数
 * @param string $name
 * @param string $value
 * @return bool|null|string
 * @throws \Psr\SimpleCache\InvalidArgumentException
 */
function setting($name=null, $value=''){
    static $_settings;
    if (!is_array($_settings)) {
        $_settings = Settings::getCache();
    }
    if (is_null($name)) {
        return $_settings;
    }else {
        if ($value === ''){
            return isset($_settings[$name]) ? $_settings[$name] : null;
        }elseif (is_null($value)){
            unset($_settings[$name]);
            return true;
        }else {
            $_settings[$name] = $value;
            return $value;
        }
    }
}

if (!function_exists('substring')){
    /**
     * @param $str
     * @param $length
     * @param string $dot
     * @return string
     */
    function substring($str, $length, $dot='...'){
        if (mb_strlen($str) <= $length) {
            return $str;
        }else {
            return mb_substr($str, 0, $length).$dot;
        }
    }
}

/**
 * 格式化距离
 * @param string $distance
 * @return string
 */
function distance($distance){
    if (!$distance) return '';
    if ($distance < 1000){
        return $distance.'m';
    }else {
        return number_format($distance/1000,2).'km';
    }
}

/**
 * 计算两点之间的距离
 * @param $lat1
 * @param $lng1
 * @param $lat2
 * @param $lng2
 * @return float
 */
function getDistance($lat1,$lng1,$lat2,$lng2){
    $earthRadius = 6377830;
    $lat1 = ($lat1 * pi() ) / 180;
    $lng1 = ($lng1 * pi() ) / 180;

    $lat2 = ($lat2 * pi() ) / 180;
    $lng2 = ($lng2 * pi() ) / 180;

    $calcLongitude = $lng2 - $lng1;
    $calcLatitude  = $lat2 - $lat1;
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);  $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
    $calculatedDistance = $earthRadius * $stepTwo;
    return round($calculatedDistance);
}

/**
 * 16位MD5散列值
 * @param $str
 * @return string
 */
function md5_16($str){
    return substr(md5($str), 0, 16);
}

/**
 * discuz 加减密方法
 * @param string $string
 * @param number $decode
 * @param string $key
 * @param number $expiry
 * @return string
 */
function authcode($string, $decode = 0, $key = '', $expiry = 0) {
    $ckey_length = 4;
    $key  = md5($key ? $key : config('app.key'));
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($decode ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);

    $string = $decode ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if($decode) {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

/**获取密码密文
 * @param $password
 * @return string
 */
function encrypt_password($password) {
    if (!$password || !is_string($password)) return '';
    return sha1(md5($password));
}

/**
 * 产生一个HASH字符串
 * @return string
 */
function formhash() {
    return md5(substr(time(), 0, -4).config('app.key'));
}

/**
 * 去除一些特殊字符
 * @param string $string
 * @return mixed
 */
function dhtmlspecialchars($string) {
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = dhtmlspecialchars($val);
        }
    } else {
        $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1',
            //$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
            str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
    }
    return $string;
}

/**
 * 生成一个随机字符串
 * @param number $length
 * @param int|number $numeric
 * @return string
 */
function random($length, $numeric = 0) {
    PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
    $seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
    $hash = '';
    $max = strlen($seed) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $seed[mt_rand(0, $max)];
    }
    return $hash;
}

/**
 * 去除HTML代码和空格
 * @param string $str
 * @return mixed
 */
function stripHtml($str){
    $str = strip_tags($str);
    $str = str_replace('&amp;', '&', $str);
    $str = str_replace(array('&ldquo;','&rdquo;'),array('“','”'),$str);
    $str = preg_replace('/\s|\n\r|　/', '', $str);
    return $str;
}

/**
 * 打印数组
 * @param mixed $array
 */
function print_array($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

/**
 * 序列号ID
 * @param mixed $array
 * @return string
 */
function implodeids($array) {
    if(is_array($array) && !empty($array)) {
        return "'".implode("','", is_array($array) ? $array : array($array))."'";
    } else {
        return '';
    }
}

/**
 * 格式时间
 * @param string $time
 * @param string $format
 * @return boolean
 * @throws \Psr\SimpleCache\InvalidArgumentException
 */
function formatTime($time,$format=''){
    if(!$time) return false;
    !$format && $format = setting('dateformat');
    !$format && $format = 'Y-m-d';
    return @date($format,$time);
}

/**
 * 格式化文件尺寸
 * @param number $size
 * @return string
 */
function formatSize($size){
    $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    if ($size == 0) {
        return('n/a');
    } else {
        return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
    }
}

/**
 * 金额格式化
 * @param float $amount
 * @param number $decimals
 * @return string
 */
function formatAmount($amount, $decimals=2){
    $amount = floatval($amount);
    return @number_format($amount, $decimals, '.', '');
}

/**
 * 替换字符串
 * @param string $string
 * @param mixed $replacer
 * @return mixed
 */
function stringParser($string,$replacer){
    $result = str_replace(array_keys($replacer), array_values($replacer),$string);
    return $result;
}

/**
 * 获取当前页面地址
 * @return string
 */
function curPageURL() {
    $pageURL = 'http';
    if (!empty($_SERVER['HTTPS'])) {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["HTTP_HOST"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

/**
 * 获取用户真实IP
 * @return string
 */
function getIp() {
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * 判断是否从移动客户端访问
 */
function mobilecheck()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}

/**
 * 清除文档格式
 */
function cleanUpStyle($str){
    $str = preg_replace('/\s*mso-[^:]+:[^;"]+;?/i', "", $str);
    $str = preg_replace('/\s*margin(.*?)pt\s*;/i', "", $str);
    $str = preg_replace('/\s*margin(.*?)cm\s*;/i', "", $str);
    $str = preg_replace('/\s*text-indent:(.*?)\s*;/i', "", $str);
    $str = preg_replace('/\s*line-height:(.*?)\s*;/i', "", $str);
    $str = preg_replace('/\s*page-break-before: [^\s;]+;?"/i', "", $str);
    $str = preg_replace('/\s*font-variant: [^\s;]+;?"/i', "", $str);
    $str = preg_replace('/\s*tab-stops:[^;"]*;?/i', "", $str);
    $str = preg_replace('/\s*tab-stops:[^"]*/i', "", $str);
    $str = preg_replace('/\s*face="[^"]*"/i', "", $str);
    $str = preg_replace('/\s*face=[^ >]*/i', "", $str);
    $str = preg_replace('/\s*font:(.*?);/i', "", $str);
    $str = preg_replace('/\s*font-size:(.*?);/i', "", $str);
    $str = preg_replace('/\s*font-weight:(.*?);/i', "", $str);
    $str = preg_replace('/\s*font-family:[^;"]*;?/i', "", $str);
    $str = preg_replace('/<span style="Times New Roman&quot;">\s\n<\/span>/i', "", $str);
    return $str;
}

/**
 * php生成全球唯一id，php生成随机码，php 生成永不重复字符串
 * @return string
 */
function guid() {
    $charid = strtoupper(md5(uniqid(mt_rand(), true)));
    $uuid = substr($charid, 0, 8).
        substr($charid, 8, 4).
        substr($charid,12, 4).
        substr($charid,16, 4).
        substr($charid,20,12);
    return $uuid;
}

/**
 * @param array $array
 * @return array
 */
function rejectNullValues($array){
    foreach ($array as $key=>$value){
        if (is_null($value)) {
            $array[$key] = '';
        }elseif (is_array($value)){
            $array[$key] = rejectNullValues($value);
        }else {
            $array[$key] = $value;
        }
    }
    return $array;
}

/**
 * @param null $data
 * @return \Illuminate\Http\JsonResponse
 */
function ajaxReturn($data = null){
    $return = array('errcode'=>0,'errmsg'=>'success');
    if (!is_null($data)) $return['data'] = $data;
    //return response(json_encode($return, JSON_UNESCAPED_UNICODE))->header('Content-type', 'application/json');
    return response()->json($return);
}

/**
 * @param $errcode
 * @param $errmsg
 * @param null $data
 * @return \Illuminate\Http\JsonResponse
 */
function ajaxError($errcode, $errmsg, $data=null){
    $return = array('errcode'=>$errcode,'errmsg'=>$errmsg);
    if (!is_null($data)) $return['data'] = $data;
    //return response(json_encode($return, JSON_UNESCAPED_UNICODE))->header('Content-type', 'application/json');
    return response()->json($return);
}

/**
 * @param $path
 * @return string
 */
function storage_url($path = '') {
    return config('filesystems.disks.public.url').'/'.$path;
}

/**
 * @param string $path
 * @return string
 */
function storage_public_path($path = ''){
    return config('filesystems.disks.public.root').'/'.$path;
}

/**
 * @param $path
 * @return string
 */
function image_url($path){
    if (is_file(storage_public_path($path))) {
        return storage_url($path);
    }else {
        return asset('images/common/nopic.png');
    }
}

/**
 * @param $uid
 * @param string $size
 * @return string
 */
function avatar($uid, $size = 'big'){
    $code = base64_encode(serialize(['uid'=>$uid, 'size'=>$size]));
    return url('avatar/'.$code);
}

/**
 * @param $aid
 * @return string
 */
function post_url($aid) {
    return action('Post\DetailController@index', ['aid'=>$aid]);
}

/**
 * @param $aid
 * @return string
 */
function post_mobile_url($aid){
    return action('Mobile\PostController@detail', ['aid'=>$aid]);
}

/**
 * 分页函数
 * @param int $curPage
 * @param int $pageSize
 * @param int $totalCount
 * @param array|string $params
 * @param bool $showTotal
 * @return string
 */
function mutipage($curPage, $pageSize, $totalCount, $params = array(), $showTotal=true){
    $multipage = '<ul class="pagination">';
    $multipage.= $showTotal ? '<li><span>总计'.$totalCount.'条</span></li>' : '';
    $url = \Illuminate\Support\Facades\URL::current();
    $params = is_array($params) ? http_build_query($params) : $params;
    if ($params) {
        $url = strpos($url, '?') ? $url.'&'.$params : $url.'?'.$params;
    }
    $url = strpos($url, '?') ? $url.'&' : $url.'?';

    $pageCount = $totalCount < $pageSize ? 1 : ceil($totalCount/$pageSize);
    $curPage = min(array($curPage, $pageCount));

    if ($curPage == 1) {
        $multipage.= '<li class="disabled"><span>&laquo;</span></li>';
    }else {
        $multipage.= "<li><a href=\"{$url}page=".($curPage-1)."\">&laquo;</a></li>";
    }

    if ($pageCount < 10) {
        for ($i=1; $i<=$pageCount; $i++){
            if($i == $curPage){
                $multipage.="<li class=\"active\"><span>$i</span></li>";
            }else{
                $multipage.="<li><a href=\"{$url}page=$i\">$i</a></li>";
            }
        }
    }else {
        if ($curPage > 5 && $curPage < $pageCount-4){
            $multipage.= "<li><a href=\"{$url}page=1\">1</a></li>";
            $multipage.= "<li><a href=\"{$url}page=2\">2</a></li>";
            $multipage.= '<li class="disabled"><span>...</span></li>';

            $page = $curPage - 2;
            for ($i = 0; $i<5; $i++){
                if($page == $curPage){
                    $multipage.="<li class=\"active\"><span>$page</span></li>";
                }else{
                    $multipage.="<li><a href=\"{$url}page=$page\">$page</a></li>";
                }
                $page++;
            }
            $multipage.= '<li class="disabled"><span>...</span></li>';
            $multipage.= "<li><a href=\"{$url}page=".($pageCount-1)."\">".($pageCount-1)."</a></li>";
            $multipage.= "<li><a href=\"{$url}page=".$pageCount."\">".$pageCount."</a></li>";
        }else {
            if ($curPage < 7){
                for ($page=1; $page<7; $page++){
                    if($page == $curPage){
                        $multipage.="<li class=\"active\"><span>$page</span></li>";
                    }else{
                        $multipage.="<li><a href=\"{$url}page=$page\">$page</a></li>";
                    }
                }
            }else {
                $multipage.= "<li><a href=\"{$url}page=1\">1</a></li>";
                $multipage.= "<li><a href=\"{$url}page=2\">2</a></li>";
            }
            $multipage.= '<li class="disabled"><span>...</span></li>';

            if ($curPage > ($pageCount-5)){
                for ($page = $pageCount - 5; $page<=$pageCount; $page++){
                    if($page == $curPage){
                        $multipage.="<li class=\"active\"><span>$page</span></li>";
                    }else{
                        $multipage.="<li><a href=\"{$url}page=$page\">$page</a></li>";
                    }
                }
            }else {
                $multipage.= "<li><a href=\"{$url}page=".($pageCount-1)."\">".($pageCount-1)."</a></li>";
                $multipage.= "<li><a href=\"{$url}page=".$pageCount."\">".$pageCount."</a></li>";
            }
        }
    }

    if ($curPage < $pageCount){
        $multipage.= "<li><a href=\"{$url}page=".($curPage+1)."\">&raquo;</a></li>";
    }else {
        $multipage.= '<li class="disabled"><span>&raquo;</span></li>';
    }

    return   $multipage.'</ul>';
}

/**
 * @param $job_id
 * @return string
 */
function job_url($job_id){
    return action('Job\DetailController@index', ['job_id'=>$job_id]);
}
