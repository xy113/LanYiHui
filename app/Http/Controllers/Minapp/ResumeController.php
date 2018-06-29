<?php

namespace App\Http\Controllers\Minapp;

use App\Models\MemberArchive;
use App\Models\MemberEducation;
use App\Models\Resume;
use App\Models\ResumeEdu;
use App\Models\ResumeWork;

class ResumeController extends BaseController
{

    public function get()
    {
        $id = $this->request->input('id');
        $resume = Resume::where('uid', $this->uid)->where('id', $id)->first();
        return ajaxReturn(['resume'=>$resume]);
    }

    /**
     *
     */
    public function batchget(){
        $items = Resume::where('uid', $this->uid)->orderByDesc('id')->get();
        return ajaxReturn(['items'=>$items]);
    }


    /**
     * 生成会员简历
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function generate()
    {
        $archive = MemberArchive::where('uid',$this->uid)->first();
        if(!$archive){
            return ajaxError(1, '请先填写会员信息');
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
                $education = new ResumeEdu();
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

    public function save()
    {
        $id = $this->request->input('id');
        $resume = $this->request->input('resume');
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
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete()
    {
        $id = $this->request->input('id');
        Resume::where('uid', $this->uid)->where('id', $id)->delete();
        return ajaxReturn();
    }
}
