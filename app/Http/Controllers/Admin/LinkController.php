<?php

namespace App\Http\Controllers\Admin;

use App\Models\Link;

class LinkController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $this->appends([
            'categorylist'=>[],
            'itemlist'=>[]
        ]);

        Link::where('type', 'category')->get()->map(function ($c){
            $this->data['categorylist'][$c->id] = $c;
        });

        Link::where('type', 'item')->get()->map(function ($c){
            $this->data['itemlist'][$c->catid][$c->id] = $c;
        });

        return view('admin.common.link', $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(){
        $delete = $this->request->input('delete');
        if ($delete && is_array($delete)){
            foreach ($delete as $id){
                Link::where('id', $id)->delete();
            }
        }

        $itemlist = $this->request->input('itemlist');
        if ($itemlist && is_array($itemlist)) {
            foreach ($itemlist as $id=>$item){
                if ($item['title']) {
                    if ($id > 0){
                        Link::where('id', $id)->update($item);
                    }else {
                        Link::insert($item);
                    }
                }
            }
        }
        return $this->showSuccess(trans('ui.save_succeed'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function setimage(){
        $id = $this->request->input('id');
        $image = $this->request->input('image');
        if ($id && $image){
            Link::where('id', $id)->update(['image'=>$image]);
        }
        return ajaxReturn();
    }
}
