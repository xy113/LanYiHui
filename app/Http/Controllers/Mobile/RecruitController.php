<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Collection;
use App\Models\RecruitCatlog;
use App\Models\RecruitItem;
use App\Models\RecruitRecord;
use App\Models\Resume;
use App\Http\Controllers\Controller;

class RecruitController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $catid = $this->request->get('catid');
        $catlog = RecruitCatlog::where('catid', $catid)->first();
        if ($catlog) $this->assign(['catlog'=>$catlog]);

        $items = RecruitItem::where('catid', $catid)->orderBy('id', 'DESC')->paginate(10);
        $this->assign([
            'itemlist'=>$items,
            'pagination'=>$items->appends(['catid'=>$catid])->links()
        ]);

        return $this->view('mobile.recruit.list');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id){

        $recruit = RecruitItem::where('id', $id)->first();
        if(Collection::where(['data_id'=>$id,'uid'=>$this->uid,'data_type'=>'recruit'])->first()){
            $collect = 1;
        }else{
            $collect = 0;
        }
        if ($recruit) $this->assign(['recruit'=>$recruit,'collect'=>$collect]);

        return $this->view('mobile.recruit.detail');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function enroll(){

        if ($this->isOnSubmit()) {
            $recruit_id = $this->request->get('recruit_id');
            $resume_id = $this->request->post('resume_id');
            if (!RecruitRecord::where(['uid'=>$this->uid, 'recruit_id'=>$recruit_id])->exists()){
                $resume = Resume::where(['uid'=>$this->uid,'id'=>$resume_id])->first();
                RecruitRecord::insert([
                    'uid'=>$this->uid,
                    'username'=>$this->username,
                    'resume_id'=>$resume_id,
                    'fullname'=>$resume['name'],
                    'created_at'=>time(),
                    'recruit_id'=>$recruit_id
                ]);
                RecruitItem::where('id', $recruit_id)->increment('enrolment');
            }
            return ajaxReturn();
        }else {

            $itemlist = Resume::where('uid', $this->uid)->get();
            $this->assign(['itemlist'=>$itemlist]);

            return $this->view('mobile.recruit.enroll');
        }
    }
}
