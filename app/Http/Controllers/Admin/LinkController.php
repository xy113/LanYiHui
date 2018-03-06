<?php

namespace App\Http\Controllers\Admin;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    public function index(){
        $data = [
            'categorylist'=>[],
            'itemlist'=>[]
        ];

        foreach (Link::where('type', 'category')->get() as $c){
            $data['categorylist'][$c->id] = $c->toArray();
        }

        foreach (Link::where('type', 'item')->get() as $c){
            $data['itemlist'][$c->catid][$c->id] = $c->toArray();
        }

        return view('admin.common.link', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(Request $request){
        $delete = $request->input('delete');
        if ($delete && is_array($delete)){
            foreach ($delete as $id){
                Link::where('id', $id)->delete();
            }
        }

        $itemlist = $request->input('itemlist');
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

    public function setimage(Request $request){
        $id = $request->input('id');
        $image = $request->input('image');
        if ($id && $image){
            Link::where('id', $id)->update(['image'=>$image]);
        }
        return ajaxReturn();
    }
}
