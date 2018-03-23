<?php

namespace App\Http\Controllers\Admin;

use App\Models\Express;

class ExpressController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $this->data['itemlist'] = [];
        Express::orderBy('id', 'ASC')->get()->map(function ($item){
            $this->data['itemlist'][$item->id] = $item;
        });
        return $this->view('admin.common.express');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(){
        $delete = $this->request->input('delete');
        if ($delete && is_array($delete)){
            foreach ($delete as $id){
                Express::where('id', $id)->delete();
            }
        }
        $itemlist = $this->request->input('itemlist');
        if ($itemlist && is_array($itemlist)){
            foreach ($itemlist as $id=>$item){
                $item = rejectNullValues($item);
                if ($item['name']) {
                    if ($id > 0) {
                        Express::where('id', $id)->update($item);
                    }else {
                        Express::insert($item);
                    }
                }
            }
        }
        return $this->showSuccess(trans('ui.save_succeed'));
    }
}
