<?php

namespace App\Http\Controllers\Join;

use App\Models\MemberArchive;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * IndexController constructor.
     * @param Request $request
     */
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(function (Request $req, $next){
            if (MemberArchive::where('uid', $this->uid)->exists()){
                return redirect()->to('member/settings/archive');
            }
            return $next($req);
        })->except(['index']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        return $this->view('join.index');
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
            return $this->view('join.enroll');
        }
    }
}
