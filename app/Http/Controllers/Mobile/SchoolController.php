<?php

namespace App\Http\Controllers\Mobile;

use App\Models\MemberEducation;
use App\Models\School;
use App\Models\SfApply;
use Illuminate\Http\Request;

class SchoolController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $school1 = MemberEducation::where('uid',$this->uid)->where('status','1')->get();
        $school2 = MemberEducation::where('uid',$this->uid)->where('status','2')->get();
        $tmp1 = [];
        $tmp2 = [];
        foreach ($school1 as $s){
//            return json_encode($s);
            array_push($tmp1,$s['school']);
        }
        foreach ($school2 as $s){
//            return json_encode($s);
            array_push($tmp2,$s['school']);
        }
        $tmp1 = array_unique($tmp1);
        $tmp2 = array_unique($tmp2);
        $tmp1 = array_diff($tmp1,$tmp2);
        $list1 = [];
        $list2 = [];
        foreach ($tmp2 as $t){
            $tmp['school'] = $t;
            $tmp['count'] = MemberEducation::where('school',$t)->where('status','>','0')->get()->count();
            array_push($list1,$tmp);
        }
        foreach ($tmp1 as $t){
            $tmp['school'] = $t;
            $tmp['count'] = MemberEducation::where('school',$t)->where('status','>','0')->get()->count();
            array_push($list2,$tmp);
        }
        $this->assign([
            'list1' => $list1,
            'list2' => $list2
        ]);

        return $this->view('mobile.member.schoolfellow.index');
    }
    public function schoolfellow(){
        $school = $this->request->get('school');
        $res = MemberEducation::where(['school'=>$school,'uid'=>$this->uid])->where('status','>','0')->count();
        $authority = 0;
        if ($res>0){
            $authority = 1;
        }
        $list = MemberEducation::where('school',$school)->orderBy('end_time','DESC')->groupBy('uid')->get();
//        return json_encode($list);
        $this->assign([
           'list'=>$list,
            'school'=>$school,
            'authority'=>$authority
        ]);
        return $this->view('mobile.member.schoolfellow.list');
    }
}
