<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $uid = 0;
    protected $username = '';
    protected $request;

    /**
     * Controller constructor.
     */
    function __construct(Request $request)
    {
        //dump($request->cookies);exit();
        //$this->uid = Cookie::get('uid');
        //$this->username = Cookie::get('username');
        $this->request = $request;
        $this->uid = $request->cookie('uid');
        $this->username = $request->cookie('username');
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
        return view('common.message',['msg'=>$msg, 'type'=>$type, 'forward'=>$forward,'links'=>$links, 'tips'=>$tips, 'autoredirect'=>$autoredirect]);
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
