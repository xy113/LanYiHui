<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Pages;

class PagesController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        return view('mobile.pages.list', $this->data);
    }

    /**
     * @param $pageid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($pageid) {

        $page = Pages::where('pageid', $pageid)->first();
        $this->assign([
            'pageid'=>$pageid,
            'page'=>$page
        ]);

        return $this->view('mobile.pages.detail');
    }
}
