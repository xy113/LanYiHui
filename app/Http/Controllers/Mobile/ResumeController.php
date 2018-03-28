<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Resume;

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
                if ($resume) $this->assign(['resume'=>$resume]);
            }

            return $this->view('mobile.resume.edit');
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
}
