<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Collection;

class FavoriteController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        return $this->view('mobile.favorite.index');
    }


    public function getjson(){

        $type = $this->request->input('type');
        $itemlist = Collection::where('data_type', $type)->get()->map(function ($item) use (&$itemlist){
            $item->image = image_url($item->image);
            return $item;
        });

        return ajaxReturn($itemlist);
    }
}
