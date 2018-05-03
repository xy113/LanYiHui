<?php

namespace App\Http\Controllers\Company;

use App\Models\JobRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResumeController extends BaseController
{
    public function index(){
        if ($this->isOnSubmit()) {

        }else {
            $job_id = $this->request->get('job_id');
            if ($job_id){
                $itemlist = JobRecord::where(['company_id'=>$this->company_id,'job_id'=>$job_id])->orderBy('created_at', 'DESC')->paginate(20);
            }else{
                $itemlist = JobRecord::where(['company_id'=>$this->company_id])->orderBy('created_at', 'DESC')->paginate(20);
            }
            $this->assign([
                'itemlist'=>$itemlist,
                'pagination'=>$itemlist->links()
            ]);
            return $this->view('company.resume.list');
        }
    }
    public function detail(){
        $id = $this->request->get('id');
        $record = JobRecord::where(['company_id'=>$this->company_id,'id'=>$id])->first();
        if($record['status']=='0'){
            $record['status'] ='1';
            $record->save();
        }
        $this->assign([
            'resume'=>$record->resume,
            'job'=>$record->job,
            'record'=>$record
        ]);
        return $this->view('company.resume.detail');
    }

    public function dealResume(){
        $req = $this->request->post();
        $record = JobRecord::where(['company_id'=>$this->company_id,'id'=>$req['id']])->first();
        if($record['status']=='0'||$record['status']=='1'){
            $record['status'] = $req['status'];
            $record->save();
            return ajaxReturn();
        }else{
            $res['errcode'] = -1;
            $res['msg'] = '当前状态不可修改！';
            return json_encode($res);
        }
    }
}
