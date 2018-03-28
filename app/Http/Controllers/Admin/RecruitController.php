<?php

namespace App\Http\Controllers\Admin;

use App\Models\RecruitCatlog;
use App\Models\RecruitItem;

class RecruitController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(){

        if ($this->isOnSubmit()) {
            $items = $this->request->post('items');
            if ($items) {
                foreach ($items as $id) {
                    RecruitItem::where('id', $id)->delete();
                }
            }
            return ajaxReturn();
        }else {

            $condition = [];
            $q = $this->request->get('q');
            $this->assign(['q'=>$q]);
            if ($q) $condition[] = ['title', 'LIKE', "%$q%"];

            $catid = $this->request->get('catid');
            $this->assign(['catid'=>$catid]);
            if ($catid) $condition[] = ['catid', '=', $catid];

            $items = RecruitItem::where($condition)->orderBy('id', 'DESC')->paginate(20);
            $this->assign([
                'pagination'=>$items->links(),
                'catloglist'=>[],
                'itemlist'=>[],
            ]);

            RecruitCatlog::all()->map(function ($catlog){
                $this->data['catloglist'][$catlog->catid] = $catlog;
            });

            $items->map(function ($item){
                $item->typename = isset($this->data['catloglist'][$item->catid]) ?  $this->data['catloglist'][$item->catid]['name'] : '';
                $this->data['itemlist'][$item->id] = $item;
            });

            return $this->view('admin.recruit.list');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function publish(){

        $id = $this->request->get('id');
        if ($this->isOnSubmit()) {
            $item = $this->request->post('item');
            if ($id) {
                $item['updated_at'] = time();
                RecruitItem::where('id', $id)->update($item);
            }else {
                $item['uid'] = $this->uid;
                $item['username'] = $this->username;
                $item['created_at'] = time();
                RecruitItem::insert($item);
            }

            return $this->showSuccess(trans('ui.save_succeed'));
        }else {

            $this->assign([
                'id'=>$id,
                'item'=>[
                    'title'=>'',
                    'num'=>1,
                    'content'=>'',
                    'image'=>'',
                    'catid'=>0
                ],
                'catloglist'=>RecruitCatlog::all()
            ]);

            if ($id) {
                $item = RecruitItem::where('id', $id)->first();
                if ($item) $this->assign(['item'=>$item]);
            }

            return $this->view('admin.recruit.publish');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function catlog(){
        if ($this->isOnSubmit()) {
            $delete = $this->request->post('delete');
            if ($delete) {
                foreach ($delete as $catid) {
                    RecruitItem::where('catid', $catid)->delete();
                    RecruitCatlog::where('catid', $catid)->delete();
                }
            }

            $itemlist = $this->request->post('itemlist');
            if ($itemlist) {
                foreach ($itemlist as $catid=>$item) {
                    if ($item['name']) {
                        if ($catid > 0) {
                            RecruitCatlog::where('catid', $catid)->update($item);
                        }else {
                            RecruitCatlog::insert($item);
                        }
                    }
                }
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {

            $items = RecruitCatlog::orderBy('catid', 'ASC')->get();
            $this->assign(['itemlist'=>$items]);

            return $this->view('admin.recruit.catlog');
        }
    }
}
