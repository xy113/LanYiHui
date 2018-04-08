<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Resume;
use App\Models\ResumeEdu;
use App\Models\ResumeWork;

class ResumeController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $itemlist = Resume::where('uid', $this->uid)->get();
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
                Resume::where(['uid'=>$this->uid, 'id'=>$id])->update($resume);
            }else {
                $resume['created_at'] = time();
                $resume['uid'] = $this->uid;
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
                    'introduction'=>''
                ]
            ]);

            if ($id) {
                $resume = Resume::where(['uid'=>$this->uid,'id'=>$id])->first();
                $edus = $resume->edus;
                if ($resume) $this->assign(['resume'=>$resume,'edus'=>$edus,'works'=>$resume->works]);
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
        return ajaxReturn();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id){

        $this->assign([
            'id'=>$id,
            'resume'=>Resume::where(['uid'=>$this->uid, 'id'=>$id])->first()
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
            $education['end_time'] = $edu['end_time'];
            $education->save();
            return ajaxReturn();
//            return url('mobile/resume/edit?id='.$edu['resume_id']);
        }else{
            if($id){
                $edu = ResumeEdu::find($id);
                $this->assign(['education'=>$edu]);
            }else{
                $edu['resume_id'] = $resume_id;
                $edu['end_time'] = '';
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
            $work['start_time'] = $w['start_time'];
            $work['end_time'] = $w['end_time'];
            $work['experience'] = $w['experience'];
            $work->save();
            return ajaxReturn();
//            return url('mobile/resume/edit?id='.$edu['resume_id']);
        }else{
            if($id){
                $w = ResumeWork::find($id);
                $this->assign(['work'=>$w]);
            }else{
                $w['resume_id'] = $resume_id;
                $w['start_time'] = '';
                $w['end_time'] = '';
                $w['company'] = '';
                $w['job'] = '';
                $w['experience'] = '';
                $w['id'] = null;
                $this->assign(['work'=>$w]);
            }
            return $this->view('mobile.resume.work');
        }
    }
}
