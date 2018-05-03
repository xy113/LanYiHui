<?php

namespace App\Http\Controllers\Mobile;

use App\Models\MemberArchive;
use App\Models\MemberEducation;
use App\Models\Resume;
use App\Models\ResumeEdu;
use App\Models\ResumeWork;
use Illuminate\Http\Request;

class ResumeController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $itemlist = Resume::where(['uid'=> $this->uid, 'status'=>'1'])->get();
        $this->assign(['itemlist'=>$itemlist]);

        return $this->view('mobile.resume.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(){

        $id = $this->request->get('id');
        if ($this->isOnSubmit()) {
            $resume = $this->request->post('resume');
            if ($id) {
                $resume['updated_at'] = time();
                $resume['status'] = '1';
                Resume::where(['uid'=>$this->uid, 'id'=>$id])->update($resume);
            }else {
                $resume['created_at'] = time();
                $resume['uid'] = $this->uid;
                $resume['status'] = '1';
                Resume::insert($resume);
            }
            return ajaxReturn();
        }else {
            $this->assign([
                'id'=>$id,
                'resume'=>[
                    'title'=>'',
                    'name'=>'',
                    'gender'=>'',
                    'age'=>'',
                    'phone'=>'',
                    'email'=>'',
                    'university'=>'',
                    'graduation_year'=>'',
                    'education'=>'',
                    'major'=>'',
                    'work_exp'=>'',
                    'work_history'=>'',
                    'introduction'=>'',
                    'address'=>''
                ],
                'edus'=>[
                ],
                'works'=>[
                ]
            ]);

            if ($id) {
                $resume = Resume::where(['uid'=>$this->uid,'id'=>$id])->first();
                $edus = $resume->edus()->orderBy('end_time','ASE')->get();
                if ($resume) $this->assign(['resume'=>$resume,'edus'=>$edus,'works'=>$resume->works()->orderBy('end_time','ASE')->get()]);
            }else{
                $old = Resume::where(['uid'=>$this->uid,'status'=>'0'])->first();
                if ($old){
                    return redirect('/mobile/resume/edit?id='.$old['id']);
                }else{
                    $resume = new Resume;
                    $resume['uid'] = $this->uid;
                    $resume->save();
                    return redirect('/mobile/resume/edit?id='.$resume['id']);
                }
            }

            return $this->view('mobile.resume.edit');
//            return json_encode(Resume::where(['uid'=>$this->uid,'id'=>$id])->first()->edus);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(){
        $id = $this->request->get('id');
        Resume::where(['uid'=>$this->uid,'id'=>$id])->delete();
        ResumeWork::where('resume_id',$id)->delete();
        ResumeEdu::where('resume_id',$id)->delete();
        return ajaxReturn();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id){
        $resume = Resume::where(['uid'=>$this->uid, 'id'=>$id])->first();
        $this->assign([
            'id'=>$id,
            'resume'=>$resume,
            'edus'=>$resume->edus,
            'works'=>$resume->works
        ]);

        return $this->view('mobile.resume.detail');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(){
        $id = $this->request->get('id');
        $resume = Resume::where(['id'=>$id, 'uid'=>$this->uid])->first();
        return ajaxReturn($resume);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchget(){

        $itemlist = Resume::where('uid', $this->uid)->get();
        return ajaxReturn($itemlist);
    }

    public function edu(){
        $id = $this->request->get('id');
        $resume_id = $this->request->get('resume');
        if ($this->isOnSubmit()){
            $edu = $this->request->post('education');
//            return dd($edu);
            if($id){  //编辑
                $education = ResumeEdu::find($id);
            }else{  //添加
                $education = new ResumeEdu;
                $education['resume_id'] = $edu['resume_id'];
            }
            $education['school'] = $edu['school'];
            $education['degree'] = $edu['degree'];
            $education['major'] = $edu['major'];
            $education['end_time'] = strtotime($edu['end_time']);
            $education->save();
            return ajaxReturn();
//            return url('mobile/resume/edit?id='.$edu['resume_id']);
        }else{
            if($id){
                $edu = ResumeEdu::find($id);
                $this->assign(['education'=>$edu]);
            }else{
                $time = strtotime('today');
                $edu['resume_id'] = $resume_id;
                $edu['end_time'] = $time;
                $edu['school'] = '';
                $edu['major'] = '';
                $edu['degree'] = '0';
                $edu['id'] = null;
                $this->assign(['education'=>$edu]);
            }
            return $this->view('mobile.resume.edu');
        }
    }
    public function work(){
        $id = $this->request->get('id');
        $resume_id = $this->request->get('resume');
        if ($this->isOnSubmit()){
            $w = $this->request->post('work');
//            return dd($edu);
            if($id){  //编辑
                $work = ResumeWork::find($id);
            }else{  //添加
                $work = new ResumeWork;
                $work['resume_id'] = $w['resume_id'];
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
                $w = ResumeWork::find($id);
                $this->assign(['work'=>$w]);
            }else{
                $time = strtotime('today');
                $w['resume_id'] = $resume_id;
                $w['start_time'] = $time;
                $w['end_time'] = $time;
                $w['company'] = '';
                $w['job'] = '';
                $w['experience'] = '';
                $w['id'] = null;
                $this->assign(['work'=>$w]);
            }
            return $this->view('mobile.resume.work');
        }
    }
    public function createWithArchive(){
        $archive = MemberArchive::where('uid',$this->uid)->first();
        if(!$archive){
            $res['errcode']=1;
            $res['msg']='请先填写会员信息';
            return json_encode($res);
        }
        $resume = new Resume;
        $resume['uid'] = $this->uid;
        $resume['title'] = $archive['fullname'].'的会员简历';
        $resume['name'] = $archive['fullname'];
        $resume['gender'] = $archive['sex'];
        if ($archive['birthday']){
            $resume['age'] = ceil((strtotime('today')-strtotime($archive['birthday']))/31536000);
        }
        $resume['phone'] = $archive['phone'];
        $resume['status'] = '1';
        $resume['address'] = $archive['location'];
        $resume['created_at'] = strtotime('today');
        $resume['updated_at'] = strtotime('today');
        if($archive->education()->count()>0){
            $resume['education'] = MemberEducation::where('uid',$this->uid)->orderBy('degree','DESC')->first()['degree'];
        }
        if($archive->work()->count()>0){
            $resume['work_exp'] = ceil((strtotime('today')-$archive->work()->orderBy('start_time','ASC')->first()['start_time'])/31536000);
        }
        $resume->save();
        foreach ($archive->education as $edu){
            if ($edu['status']>0){
                $education = new ResumeEdu;
                $education['resume_id'] = $resume['id'];
                $education['school'] = $edu['school'];
                $education['degree'] = $edu['degree'];
                $education['major'] = $edu['major'];
                $education['start_time'] = $edu['start_time'];
                $education['end_time'] = $edu['end_time'];
                $education->save();
            }
        }
        foreach ($archive->work as $work){
            $newWork = new ResumeWork();
            $newWork['resume_id'] = $resume['id'];
            $newWork['company'] = $work['company'];
            $newWork['experience'] = $work['experience'];
            $newWork['job'] = $work['job'];
            $newWork['start_time'] = $work['start_time'];
            $newWork['end_time'] = $work['end_time'];
            $newWork->save();
        }
        return ajaxReturn();
    }
}
