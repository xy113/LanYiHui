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
use Illuminate\Support\Facades\URL;

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
                    'uid'=>$uid,
                    'username'=>$username,
                    'islogined'=>true
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
     * @param string $msg
     * @param string $type
     * @param string $forward
     * @param array $links
     * @param string $tips
     * @param bool $autoredirect
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function showMessage($msg='', $type='success', $forward=null, $links=[], $tips='', $autoredirect=false){

        $type = in_array($type, ['error', 'warning', 'information']) ? $type : 'success';
        if (empty($links)) {
            $links = [
                [
                    'text'=>trans('common.go_back'),
                    'url'=>URL::previous()
                ]
            ];
        }else {
            $newlinks = [];
            foreach ($links as $link){
                if (isset($link['target'])){
                    $link['target'] = in_array($link['target'], ['_blank','_top','_self']) ? $link['target'] : '';
                }else {
                    $link['target'] = '';
                }

                $newlinks[] = $link;
            }
            $links = $newlinks;
        }
        $forward = $forward ? $forward : ($links ? $links[0]['url'] : URL::previous());
        $this->assign([
            'msg'=>$msg,
            'type'=>$type,
            'forward'=>$forward,
            'tips'=>$tips,
            'links'=>$links,
            'autoredirect'=>$autoredirect
        ]);
        return $this->view($this->messageView);
    }

    /**
     * @param $msg
     * @param string $forward
     * @param array $links
     * @param string $tips
     * @param bool $autoredirect
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function showSuccess($msg, $forward='', $links=[], $tips='', $autoredirect=false){
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
    protected function showError($msg, $forward='', $links=[], $tips='', $autoredirect=false){
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
    protected function showWarning($msg, $forward='', $links=[], $tips='', $autoredirect=false){
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
    protected function showInformation($msg, $forward='', $links=[], $tips='', $autoredirect=false){
        return $this->showMessage($msg,'information',$forward,$links,$tips,$autoredirect);
    }
}
