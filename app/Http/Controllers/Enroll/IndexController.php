<?php

namespace App\Http\Controllers\Enroll;

use App\Models\MemberArchive;

class IndexController extends BaseController
{
    public function index(){

        return view('enroll.index', $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function enroll(){

        if ($this->isOnSubmit()) {
            MemberArchive::insert([
                'uid'=>$this->uid,
                'username'=>$this->username,
                'fullname'=>$this->request->post('fullname'),
                'phone'=>$this->request->post('phone'),
                'sex'=>$this->request->post('sex'),
                'birthday'=>$this->request->post('birthday'),
                'university'=>$this->request->post('university'),
                'enrollyear'=>$this->request->post('enrollyear'),
                'birthplace'=>$this->request->post('birthplace'),
                'location'=>$this->request->post('location'),
                'status'=>0,
                'created_at'=>time()
            ]);
            return ajaxReturn();
        }else {
            return view('enroll.enroll', $this->data);
        }
    }
}
