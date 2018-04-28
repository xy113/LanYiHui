<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Member;
use App\Models\MemberArchive;
use App\Models\MemberEducation;
use App\Models\MemberExperience;
use App\Models\MemberInfo;
use App\Models\MemberWork;
use Illuminate\Http\Request;

class MemberController extends BaseController
{
    public function index(){

        $this->assign(['background'=>'url(../images/mobile/head-bg.jpg)','username'=>Member::find($this->uid)['username']]);
        return $this->view('mobile.member.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info(){
        if ($this->isOnSubmit()) {
            $req = $this->request->post('user');
            $memberinfo = MemberInfo::find($this->uid);
            $memberinfo['name'] = $req['fullname'];
            $memberinfo['sex'] = $req['sex'];
            $memberinfo['qq'] = $req['qq'];
            $memberinfo['birthday'] = $req['birthday'];
            $memberinfo['introduction'] = $req['introduction'];
            $memberinfo->save();
            $member = Member::find($this->uid);
            $member['username'] = $req['name'];
            $member['mobile'] = $req['phone'];
            $member['email'] = $req['email'];
            $member->save();
            return ajaxReturn();
        }else {
            $this->assign([
                'member'=>Member::find($this->uid)->toArray(),
                'user'=>MemberInfo::find($this->uid)->toArray(),
                'sex_items'=>trans('member.sex_items')
            ]);

            return $this->view('mobile.member.userinfo');
        }
    }
    public function archive(){

        $archive = MemberArchive::where('uid', $this->uid)->first();
        $experience = $archive->experience;
        $works = $archive->work;
        $education = $archive->education;
        $this->assign([
            'archive'=>$archive,
            'experience'=>$experience,
            'edus'=>$education,
            'works'=>$works,
            'verify_status'=>trans('member.verify_status')
        ]);

        return $this->view('mobile.member.archive');
    }
    /**
    */
    public function experienceEdit(){
        if ($this->isOnSubmit()) {
            $req = $this->request->post('experience');
            $experience = MemberExperience::find($req['id']);
            $experience['year'] = $req['year'];
            $experience['vacation'] = $req['vacation'];
            $experience['part'] = $req['part'];
            $experience['department'] = $req['department'];
            $experience['role'] = $req['role'];
            $experience['description'] = $req['description'];
            $experience['updated_at'] = time();
            $experience->save();
            return ajaxReturn();
        }else {
            $id = $this->request->get('id');
            $this->assign([
                'experience'=>MemberExperience::find($id),
            ]);

            return $this->view('mobile.member.experience');
        }
    }
    /**
     */
    public function experienceAdd(){
        if ($this->isOnSubmit()) {
            $req = $this->request->post('experience');
            $experience = new MemberExperience;
            $experience['uid'] = $this->uid;
            $experience['year'] = $req['year'];
            $experience['vacation'] = $req['vacation'];
            $experience['part'] = $req['part'];
            $experience['department'] = $req['department'];
            $experience['role'] = $req['role'];
            $experience['description'] = $req['description'];
            $experience['updated_at'] = time();
            $experience['created_at'] = time();
            $experience->save();
            return ajaxReturn();
        }else {
            return $this->view('mobile.member.experienceAdd');
        }
    }

    public function edit(Request $request){
        if ($this->isOnSubmit()) {
            $user = $request->post('user');
            MemberArchive::where('uid', $this->uid)->update($user);
            return ajaxReturn();
        }else {
            $user = MemberArchive::where('uid', $this->uid)->first();
            $this->assign([
                'user'=>$user,
                'verify_status'=>trans('member.verify_status')
            ]);
            return $this->view('mobile.member.edit');
        }
    }


    public function education(){
        $id = $this->request->get('id');
        if ($this->isOnSubmit()){
            $edu = $this->request->post('education');
//            return dd($edu);
            if($id){  //编辑
                $education = MemberEducation::find($id);
                if ($education['status']=='2'&&$education['school']==$edu['school']){
//                    $res['errcode'] = 1;
                    if ($education['major'] == $edu['major']&&$education['degree'] == $edu['degree']){

                    }else{
                        $education['status'] = '1';
                    }
                }else{
                    $education['status'] = '0';
                }
            } else{  //添加
                $education = new MemberEducation;
                $education['uid'] = $this->uid;
                $education['status'] = '0';
            }
            $education['school'] = $edu['school'];
            $education['degree'] = $edu['degree'];
            $education['major'] = $edu['major'];
            $education['start_time'] = strtotime($edu['start_time']);
            $education['end_time'] = strtotime($edu['end_time']);
            $education->save();
            return ajaxReturn();
//            return url('mobile/resume/edit?id='.$edu['resume_id']);
        }else{
            if($id){
                $edu = MemberEducation::find($id);
                $this->assign(['education'=>$edu]);
            }else{
                $time = strtotime('today');
                $edu['uid'] = $this->uid;
                $edu['start_time']=$time;
                $edu['end_time'] = $time;
                $edu['school'] = '';
                $edu['major'] = '';
                $edu['degree'] = '5';
                $edu['id'] = null;
                $this->assign(['education'=>$edu]);
            }
            return $this->view('mobile.member.education');
        }
    }
    public function work(){
        $id = $this->request->get('id');
        if ($this->isOnSubmit()){
            $w = $this->request->post('work');
//            return dd($edu);
            if($id){  //编辑
                $work = MemberWork::find($id);
                if ($work['status']=='2'){
                    $work['status'] = '1';
                }elseif ($work['status']=='-1'){
                    $work['status'] = '0';
                }
            }else{  //添加
                $work = new MemberWork;
                $work['uid'] = $this->uid;
                $work['status'] = '0';
            }
            $work['company'] = $w['company'];
            $work['job'] = $w['job'];
            $work['start_time'] = strtotime($w['start_time']);
            $work['end_time'] = strtotime($w['end_time']);
            $work['experience'] = $w['experience'];
            $work->save();
            return ajaxReturn();
//            return url('mobile/resume/edit?id='.$edu['resume_id']);
        }else{
            if($id){
                $w = MemberWork::find($id);
                $this->assign(['work'=>$w]);
            }else{
                $time = strtotime('today');
                $w['start_time'] = $time;
                $w['end_time'] = $time;
                $w['company'] = '';
                $w['job'] = '';
                $w['experience'] = '';
                $w['id'] = null;
                $this->assign(['work'=>$w]);
            }
            return $this->view('mobile.member.work');
        }
    }
    public function delete(){
        $type = $this->request->get('type');
        $id = $this->request->get('id');
        switch ($type){
            case 'experience':
                MemberExperience::where(['uid'=>$this->uid,'id'=>$id])->first()->delete();
                break;
            case 'education':
                MemberEducation::where(['uid'=>$this->uid,'id'=>$id])->first()->delete();
                break;
            case 'work':
                MemberWork::where(['uid'=>$this->uid,'id'=>$id])->first()->delete();
                break;
            default:
                $res['errcode']=1;
                $res['msg']='未知类型';
                return json_encode($res);
        }
        return ajaxReturn();
    }
}
