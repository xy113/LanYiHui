<?php

namespace App\Http\Controllers\Mobile;

class FavoriteController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        return $this->view('mobile.favorite.index');
    }
}
