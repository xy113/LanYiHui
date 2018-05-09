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
        $itemlist = Collection::where(['data_type'=>$type,'uid'=>$this->uid])->get()->map(function ($item) use (&$itemlist){
            $item->image = image_url($item->image);
            return $item;
        });

        return ajaxReturn($itemlist);
    }
//    传入 method:0/1 (0:取消关注,1:关注)  type:article/job/company  id:对应id ,title,image
    public function collect(){
        $req = $this->request->post();
        if($req['method']=='0'){
            Collection::where(['data_id'=>$req['id'],'uid'=>$this->uid])->delete();
        }else {
            $fav = Collection::where(['data_id'=>$req['id'],'uid'=>$this->uid])->count();
            if($fav>0){

            }else{
                $collection = new Collection;
                $collection['uid'] = $this->uid;
                $collection['data_id'] = $req['id'];
                $collection['data_type'] = $req['type'];
                $collection['title'] = $req['title'];
                $collection['image'] = $req['img'];
                $collection['created_at'] = time();
                $collection->save();
            }
        }
        return ajaxReturn();

    }
}
