<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\MemberGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $condition = $queryParams = [];

        $uid = $this->request->input('uid');
        $this->data['uid'] = $uid;
        if ($uid) {
            $condition[] = ['m.uid', '=', $uid];
            $queryParams['uid'] = $uid;
        }

        $username = $this->request->input('username');
        $this->data['username'] = $username;
        if ($username) {
            $condition[] = ['m.username', 'LIKE', $username];
            $queryParams['username'] = $username;
        }

        $mobile = $this->request->input('mobile');
        $this->data['mobile'] = $mobile;
        if ($mobile) {
            $condition[] = ['m.mobile', '=', $mobile];
            $queryParams['mobile'] = $mobile;
        }

        $email = $this->request->input('email');
        $this->data['email'] = $email;
        if ($email) {
            $condition[] = ['m.email', '=', $email];
            $queryParams['email'] = $email;
        }

        $reg_time_begin = $this->request->input('reg_time_begin');
        $this->data['reg_time_begin'] = $reg_time_begin;
        if ($reg_time_begin) {
            $condition[] = ['s.regdate', '>', strtotime($reg_time_begin)];
            $queryParams['reg_time_begin'] = $reg_time_begin;
        }

        $reg_time_end = $this->request->input('reg_time_end');
        $this->data['reg_time_end'] = $reg_time_end;
        if ($reg_time_end) {
            $condition[] = ['s.regdate', '<', strtotime($reg_time_end)];
            $queryParams['reg_time_end'] = $reg_time_end;
        }

        $last_visit_begin = $this->request->input('last_visit_begin');
        $this->data['last_visit_begin'] = $last_visit_begin;
        if ($last_visit_begin) {
            $condition[] = ['s.lastvisit', '>', strtotime($last_visit_begin)];
            $queryParams['last_visit_begin'] = $last_visit_begin;
        }

        $last_visit_end = $this->request->input('last_visit_end');
        $this->data['last_visit_end'] = $last_visit_end;
        if ($last_visit_end) {
            $condition[] = ['s.lastvisit', '<', strtotime($last_visit_end)];;
            $queryParams['last_visit_end'] = $last_visit_end;
        }

        $members = DB::table('member as m')
                        ->leftJoin('member_status as s', 'm.uid', '=', 's.uid')
                        ->where($condition)
                        ->select('m.*','s.regdate','s.lastvisit','s.regip','s.lastvisitip')
                        ->orderBy('uid', 'ASC')
                        ->paginate(20);
        $this->data['pagination'] = $members->appends($queryParams)->links();

        $this->data['grouplist'] = [];
        MemberGroup::all()->map(function ($group){
            $this->data['grouplist'][$group->gid] = $group;
        });

        $this->data['memberlist'] = [];
        $members->map(function ($m){
            if (isset($this->data[$m->gid])){
                $m->grouptitle = $this->data[$m->gid]->title;
            }else {
                $m->grouptitle = '';
            }

            $this->data['memberlist'][$m->uid] = $m;
        });

        $this->data['member_status'] = trans('member.member_status');
        return view('admin.member.list', $this->data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(){
        $members = $this->request->input('members');
        foreach ($members as $uid){
            if ($uid != 1000000){
                Member::deleteAll($uid);
            }
        }
        return ajaxReturn();
    }

    /**
     * 添加用户
     */
    public function add(){
        global $_G,$_lang;
        if ($this->checkFormSubmit()) {
            $errno = 0;
            $membernew = $_GET['membernew'];
            cookie('membernew',serialize($membernew),600);
            if ($membernew['username'] && $membernew['password']) {
                $returns = member_register($membernew);
                if ($returns['errno']) {
                    $this->showError($returns['error']);
                }else {
                    $this->showSuccess('member_add_succeed');
                }
            }else {
                $this->showError('invalid_parameter');
            }
        }else {

            $_Grouplist = usergroup_get_list(0);
            $member = unserialize(cookie('membernew'));

            $_G['title'] = 'memberlist';
            include template('member/member_form');
        }
    }

    /**
     * 编辑用户
     */
    public function edit(){
        $uid = intval($_GET['uid']);
        if ($this->checkFormSubmit()) {

            $membernew = $_GET['membernew'];
            if (member_get_num(array('username'=>$membernew['username'])) > 1){
                $this->showError('username_be_occupied');
            }

            if ($membernew['email']) {
                if (member_get_num(array('email'=>$membernew['email'])) > 1){
                    $this->showError('email_be_occupied');
                }
            }

            if ($membernew['mobile']) {
                if (member_get_num(array('mobile'=>$membernew['mobile'])) > 1){
                    $this->showError('mobile_be_occupied');
                }
            }

            if ($membernew['password']) {
                $membernew['password'] = getPassword($membernew['password']);
            }else {
                unset($membernew['password']);
            }

            member_update_data(array('uid'=>$uid), $membernew);
            $this->showSuccess('update_succeed');
        }else {
            global $_G,$_lang;
            $member = member_get_data(array('uid'=>$uid));
            $_Grouplist  = usergroup_get_list(0);

            $_G['title'] = 'memberlist';
            include template('member/member_form');
        }
    }

    /**
     * 移动到分组
     */
    public function moveto(){
        $uids = trim($_GET['uids']);
        $target = intval($_GET['target']);
        member_update_data(array('uid'=>array('IN', $uids)), array('gid'=>$target));
        $this->showSuccess('update_succeed', U('a=member_list&gid='.$target));
    }
}
