<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\MemberArchive;
use App\Models\MemberEducation;
use App\Models\MemberExperience;
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
        return $this->view('admin.member.list');
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archive(){
        if ($this->isOnSubmit()) {
            $members = $this->request->post('members');
            $eventType = $this->request->post('eventType');
            if ($eventType === 'delete') {
                foreach ($members as $id) {
                    MemberArchive::where('id', $id)->delete();
                }
            }

            if ($eventType === 'pass') {
                foreach ($members as $id) {
                    MemberArchive::where('id', $id)->update(['status'=>1]);
                }
            }

            if ($eventType === 'refuse') {
                foreach ($members as $id) {
                    MemberArchive::where('id', $id)->update(['status'=>-1]);
                }
            }
            return ajaxReturn();

        }else {

            $condition = $params = [];
            $fullname = $this->request->get('fullname');
            $this->data['fullname'] = $fullname;
            if ($fullname) {
                $condition[] = ['fullname', 'LIKE', "%$fullname%"];
                $params['fullname'] = $fullname;
            }

            $phone = $this->request->get('phone');
            $this->data['phone'] = $phone;
            if ($phone) {
                $condition[] = ['phone', '=', $phone];
                $params['phone'] = $phone;
            }

            $university = $this->request->get('university');
            $this->data['university'] = $university;
            if ($university) {
                $condition[] = ['university', '=', $university];
                $params['university'] = $university;
            }

            $sex = $this->request->get('sex');
            $sex = is_null($sex) ? 'all' : $sex;
            $this->data['sex'] = $sex;
            $params['sex'] = $sex;
            if ($sex !== 'all') {
                $condition[] = ['sex', '=', $sex];
            }

            $enrollyear = $this->request->get('enrollyear');
            $this->data['enrollyear'] = $enrollyear;
            if ($enrollyear) {
                $condition[] = ['enrollyear', '=', $enrollyear];
                $params['enrollyear'] = $enrollyear;
            }

            $status = $this->request->get('status');
            $status = is_null($status) ? 'all' : $status;
            $this->data['status'] = $status;
            $params['status'] = $status;
            if ($status !== 'all') {
                $condition[] = ['status', '=', $status];
            }
//            return json_encode($condition);
            $itemlist = MemberArchive::where($condition)->orderBy('id', 'ASC')->paginate(20);
            $this->assign([
                'pagination'=>$itemlist->links(),
                'itemlist'=>[]
            ]);

            $verify_status = trans('member.verify_status');
            $itemlist->map(function ($item) use ($verify_status) {
                $item->status_title = $verify_status[$item->status];
                $this->data['itemlist'][$item->id] = $item;
            });

            $this->assign(['verify_status'=>$verify_status]);
            return $this->view('admin.member.archive');
        }
    }

    /**
     * 教育经历审核页
     */
    public function education(){
        if ($this->isOnSubmit()) {
            $members = $this->request->post('members');
            $eventType = $this->request->post('eventType');
            if ($eventType === 'delete') {
                foreach ($members as $id) {
                    MemberEducation::where('id', $id)->delete();
                }
            }

            if ($eventType === 'pass') {
                foreach ($members as $id) {
                    MemberEducation::where('id', $id)->update(['status'=>'2']);
                }
            }

            if ($eventType === 'refuse') {
                foreach ($members as $id) {
                    MemberEducation::where('id', $id)->update(['status'=>'-1']);
                }
            }
            return ajaxReturn();

        }else {
            $condition = $params = [];
            $id = $this->request->get('id');
            $this->data['uid'] = $id;
            if ($id) {
                $condition[] = ['uid', '=', $id];
                $params['uid'] = $id;
            }

            $major = $this->request->get('major');
            $this->data['major'] = $major;
            if ($major) {
                $condition[] = ['major', '=', $major];
                $params['major'] = $major;
            }

            $degree = $this->request->get('degree');
            $degree = is_null($degree) ? 'all' : $degree;
            $this->data['degree'] = $degree;
            $params['degree'] = $degree;
            if($degree!='all'){
                $condition[] = ['degree', '=', $degree];
            }

            $university = $this->request->get('university');
            $this->data['university'] = $university;
            if ($university) {
                $condition[] = ['university', '=', $university];
                $params['university'] = $university;
            }

            $status = $this->request->get('status');
            $status = is_null($status) ? 'all' : $status;
            $this->data['status'] = $status;
            $params['status'] = $status;
            if ($status !== 'all') {
                $condition[] = ['status', '=', $status];
            }
//            return json_encode($condition);
            $itemlist = MemberEducation::where($condition)->orderBy('id', 'ASC')->paginate(20);
            $this->assign([
                'pagination'=>$itemlist->links(),
                'itemlist'=>[],
                'id'=>$id
            ]);

            $verify_status = trans('member.verify_status');
            $itemlist->map(function ($item) {
                $this->data['itemlist'][$item->id] = $item;
            });

            $this->assign(['verify_status'=>$verify_status]);
            return $this->view('admin.member.education');
        }
    }

    /**
     * 会员经历审核页
     */
    public function experience(){
        if ($this->isOnSubmit()) {
            $members = $this->request->post('members');
            $eventType = $this->request->post('eventType');
            if ($eventType === 'delete') {
                foreach ($members as $id) {
                    MemberExperience::where('id', $id)->delete();
                }
            }

            if ($eventType === 'pass') {
                foreach ($members as $id) {
                    MemberExperience::where('id', $id)->update(['status'=>'2']);
                }
            }

            if ($eventType === 'refuse') {
                foreach ($members as $id) {
                    MemberExperience::where('id', $id)->update(['status'=>'-1']);
                }
            }
            return ajaxReturn();

        }else {
            $condition = $params = [];
            $id = $this->request->get('id');
            $this->data['uid'] = $id;
            if ($id) {
                $condition[] = ['uid', '=', $id];
                $params['uid'] = $id;
            }

            $department = $this->request->get('department');
            $this->data['department'] = $department;
            if ($department) {
                $condition[] = ['department', 'like', '%'.$department.'%'];
                $params['department'] = $department;
            }

            $role = $this->request->get('role');
            $this->data['role'] = $role;
            if ($role) {
                $condition[] = ['role', 'like', '%'.$role.'%'];
                $params['role'] = $role;
            }

            $year = $this->request->get('year');
            $this->data['year'] = $year;
            if ($year) {
                $condition[] = ['year', '=', $year];
                $params['year'] = $year;
            }

            $part = $this->request->get('part');
            $part = is_null($part) ? 'all' : $part;
            $this->data['part'] = $part;
            $params['part'] = $part;
            if($part!='all'){
                $condition[] = ['part', '=', $part];
            }

            $vacation = $this->request->get('vacation');
            $vacation = is_null($vacation) ? 'all' : $vacation;
            $this->data['vacation'] = $vacation;
            $params['vacation'] = $part;
            if($vacation!='all'){
                $condition[] = ['vacation', '=', $vacation];
            }


            $status = $this->request->get('status');
            $status = is_null($status) ? 'all' : $status;
            $this->data['status'] = $status;
            $params['status'] = $status;
            if ($status !== 'all') {
                $condition[] = ['status', '=', $status];
            }
//            return json_encode($condition);
            $itemlist = MemberExperience::where($condition)->orderBy('id', 'ASC')->paginate(20);
            $this->assign([
                'pagination'=>$itemlist->links(),
                'itemlist'=>[],
                'id'=>$id
            ]);

            $verify_status = trans('member.verify_status');
            $itemlist->map(function ($item) {
                $this->data['itemlist'][$item->id] = $item;
            });

            $this->assign(['verify_status'=>$verify_status]);
            return $this->view('admin.member.experience');
        }
    }
}
