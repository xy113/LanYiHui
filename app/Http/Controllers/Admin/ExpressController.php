<?php

namespace App\Http\Controllers\Admin;

use App\Models\Express;
use Illuminate\Http\Request;

class ExpressController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $itemlist = [];
        foreach (Express::orderBy('id', 'ASC')->get() as $item){
            $itemlist[$item->id] = $item->toArray();
        }

        return view('admin.common.express', ['itemlist'=>$itemlist]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(Request $request){
        $delete = $request->input('delete');
        if ($delete && is_array($delete)){
            foreach ($delete as $id){
                Express::where('id', $id)->delete();
            }
        }
        $itemlist = $request->input('itemlist');
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
