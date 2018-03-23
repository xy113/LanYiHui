<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberInfo;
use App\Models\MemberStatus;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $request;

    protected $uid = 0;
    protected $username = '';
    protected $data = [
        'uid'=>0,
        'username'=>'',
        'member'=>[],
        'member_info'=>[],
        'member_status'=>[],
        'islogined'=>0
    ];

    protected $messageView = 'common.message';

    /**
     * Controller constructor.
     */
    function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware(function (Request $req, $next){
            $uid = $req->cookie('uid');
            $username = $req->cookie('username');

            if ($uid && $username) {
                $this->uid = $uid;
                $this->username = $username;
                $this->assign([
                    'uid'=>$this->uid,
                    'username'=>$this->username,
                    'islogined'=>1
                ]);
                try {
                    $member = Session::get('member');
                    if (!is_array($member)) {
                        $member = Member::where('uid', $this->uid)->first();
                        if ($member) {
                            Session::flash('member', $member);
                            $this->data['member'] = $member;
                        }
                    }

                    $memberInfo = Session::get('member_info');
                    if (!is_array($memberInfo)) {
                        $memberInfo = MemberInfo::where('uid', $this->uid)->first();
                        if ($memberInfo) {
                            Session::flash('member_info', $memberInfo);
                            $this->data['member_info'] = $memberInfo;
                        }
                    }

                    $memberStatus = Session::get('member_status');
                    if (!is_array($memberStatus)) {
                        $memberStatus = MemberStatus::where('uid', $this->uid)->first();
                        if ($memberStatus) {
                            Session::flash('member_status', $memberStatus);
                            $this->data['member_status'] = $memberStatus;
                        }
                    }
                }catch (\Exception $e){

                }
            }
            return $next($req);
        });
    }

    /**
     * @param array $array
     * @param bool $replace
     * @param string $prefix
     * @return $this
     */
    protected function assign($array = [], $replace = true, $prefix=''){
        foreach ($array as $key=>$value) {
            if (is_string($key)) {
                if (array_key_exists($key, $this->data)){
                    if ($replace) {
                        $this->data[$key] = $value;
                    }else {
                        $this->data[$prefix.$key] = $value;
                    }
                }else {
                    $this->data[$key] = $value;
                }
            }
        }
        return $this;
    }

    /**
     * @param $view
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($view, $data = []) {
        if (is_array($data) && !empty($data)) $this->assign($data);
        return view($view, $this->data);
    }

    /**
     * @return bool
     */
    protected function isOnSubmit(){
        return ($this->request->post('formsubmit') === 'yes');
    }

    /**
     * 显示系统信息
     * @param string $msg 提示信息
     * @param string $type 信息类型
     * @param string $forward 跳转页面
     * @param array $links 可选链接
     * @param string $tips 提示信息
     * @param bool $autoredirect 是否自动跳转
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function showMessage($msg='', $type='success', $forward='', $links=array(), $tips='', $autoredirect=false){

        $type = in_array($type, array('error', 'warning', 'information')) ? $type : 'success';
        if (empty($links)) {
            $links = array(
                array(
                    'text'=>trans('common.go_back'),
                    'url'=>$_SERVER['HTTP_REFERER']
                )
            );
        }else {
            $newlinks = array();
            foreach ($links as $link){
                if (isset($link['target'])){
                    $link['target'] = in_array($link['target'], array('_blank','_top','_self')) ? $link['target'] : '';
                }else {
                    $link['target'] = '';
                }

                $newlinks[] = $link;
            }
            $links = $newlinks;
            unset($newlinks);
        }
        $forward = $forward ? $forward : ($links ? $links[0]['url'] : $_SERVER['HTTP_REFERER']);
        $this->assign([
            'msg'=>$msg,
            'type'=>$type,
            'forward'=>$forward,
            'links'=>$links,
            'tips'=>$tips,
            'autoredirect'=>$autoredirect
        ]);
        return view($this->messageView, $this->data);
    }

    /**
     * @param $msg
     * @param string $forward
     * @param array $links
     * @param string $tips
     * @param bool $autoredirect
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function showSuccess($msg, $forward='', $links=array(), $tips='', $autoredirect=false){
        return $this->showMessage($msg,'success',$forward,$links,$tips,$autoredirect);
    }

    /**
     * @param $msg
     * @param string $forward
     * @param array $links
     * @param string $tips
     * @param bool $autoredirect
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function showError($msg, $forward='', $links=array(), $tips='', $autoredirect=false){
        return $this->showMessage($msg,'error',$forward,$links,$tips,$autoredirect);
    }

    /**
     * @param $msg
     * @param string $forward
     * @param array $links
     * @param string $tips
     * @param bool $autoredirect
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function showWarning($msg, $forward='', $links=array(), $tips='', $autoredirect=false){
        return $this->showMessage($msg,'warning',$forward,$links,$tips,$autoredirect);
    }

    /**
     * @param $msg
     * @param string $forward
     * @param array $links
     * @param string $tips
     * @param bool $autoredirect
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function showInformation($msg, $forward='', $links=array(), $tips='', $autoredirect=false){
        return $this->showMessage($msg,'information',$forward,$links,$tips,$autoredirect);
    }

    /**
     * @param string $message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function notFound($message=''){
        !$message && $message = 'page_not_found';
        return $this->showMessage($message,'error');
    }

    /**
     * 无权限提示
     * @param string $message
     */
    protected function noPermission($message=''){
        !$message && $message = 'no_permission';
        $this->showMessage($message,'error');
    }
}
