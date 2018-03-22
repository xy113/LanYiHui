<?php

namespace App\Http\Controllers\Mobile;

use App\Models\MemberArchive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JoinController extends Controller
{
    /**
     * JoinController constructor.
     * @param Request $request
     */
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['mobile.auth']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        return view('mobile.join', $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
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
            return view('mobile.enroll', $this->data);
        }
    }
}
