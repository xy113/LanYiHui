<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;

class AdController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(){
        if ($this->isOnSubmit()) {
            $ads = $this->request->post('ads');
            $eventType = $this->request->post('eventType');
            if ($eventType === 'delete') {
                foreach ($ads as $id) {
                    Ad::where('id', $id)->delete();
                }
            }

            if ($eventType === 'enable') {
                foreach ($ads as $id) {
                    Ad::where('id', $id)->update(['available'=>1]);
                }
            }

            if ($eventType === 'disable') {
                foreach ($ads as $id) {
                    Ad::where('id', $id)->update(['available'=>0]);
                }
            }
            return ajaxReturn();
        }else {

            $ad_types = trans('common.ad_types');
            $ads = Ad::orderBy('id', 'ASC')->paginate(20);
            $this->appends(['pagination'=>$ads->links(), 'ad_types'=>$ad_types]);

            $this->data['itemlist'] = [];
            $ads->map(function ($ad) use ($ad_types){
                $ad->type_name = $ad_types[$ad->type];
                $this->data['itemlist'][$ad->id] = $ad;
            });

            return view('admin.common.ad_list', $this->data);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit() {
        if ($this->isOnSubmit()) {
            $id = $this->request->post('id');
            $ad = $this->request->post('adnew');
            $addata = $this->request->post('addata');
            $ad['data'] = serialize($addata[$ad['type']]);
            if ($id) {
                Ad::where('id', $id)->update($ad);
            }else {
                Ad::insert($ad);
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {
            $id = intval($this->request->get('id'));
            $this->appends([
                'id'=>$id,
                'ad'=>[
                    'title'=>'',
                    'begin_time'=>'',
                    'end_time'=>'',
                    'type'=>'text'
                ],
                'addata'=>[
                    'text'=>[
                        'text'=>'',
                        'link'=>''
                    ],
                    'image'=>[
                        'image'=>'',
                        'width'=>'',
                        'height'=>'',
                        'link'=>''
                    ],
                    'code'=>''
                ],
                'ad_types'=>trans('common.ad_types')
            ]);

            if ($id) {
                $ad = Ad::where('id', $id)->first();
                if ($ad) {
                    $this->data['ad'] = $ad;
                    $this->data['addata'][$ad->type] = unserialize($ad->data);
                }
            }

            return view('admin.common.ad_edit', $this->data);
        }
    }
}
