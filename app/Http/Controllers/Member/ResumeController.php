<?php

namespace App\Http\Controllers\Member;

use App\Models\RecruitRecord;
use App\Models\Resume;

class ResumeController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        if ($this->isOnSubmit()) {
            $items = $this->request->post('items');
            if ($items) {
                foreach ($items as $id) {
                    Resume::where(['id'=>$id, 'uid'=>$this->uid])->delete();
                    RecruitRecord::where(['resume_id'=>$id, 'uid'=>$this->uid])->delete();
                }
            }

            return $this->showSuccess(trans('ui.delete_succeed'));
        }else {
            $this->assign([
                'menu'=>'resume',
                'itemlist'=>Resume::where('uid', $this->uid)->get()
            ]);
            return $this->view('member.resume.index');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){

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
            return $this->showSuccess(trans('ui.save_succeed'));
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
                if ($resume) $this->assign(['resume'=>$resume]);
            }

            return $this->view('member.resume.add');
        }
    }
}
