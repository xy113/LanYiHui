<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        if ($this->isOnSubmit()) {
            $ads = $request->post('ads');
            $eventType = $request->post('eventType');
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
            $data = [
                'itemlist'=>[],
                'pagination'=>'',
                'ad_types'=>trans('common.ad_types')
            ];

            $ads = Ad::orderBy('id', 'ASC')->paginate(20);
            $data['pagination'] = $ads->links();

            if ($ads) {
                foreach ($ads as $ad) {
                    $ad->type_name = $data['ad_types'][$ad->type];
                    $data['itemlist'][$ad->id] = $ad->toArray();
                }
            }

            return view('admin.common.ad_list', $data);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request) {
        if ($this->isOnSubmit()) {
            $id = intval($request->post('id'));
            $ad = $request->post('adnew');
            $addata = $request->post('addata');
            $ad['data'] = serialize($addata[$ad['type']]);
            if ($id) {
                Ad::where('id', $id)->update($ad);
            }else {
                Ad::insert($ad);
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {
            $id = intval($request->get('id'));
            $data = [
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
            ];

            if ($id) {
                $ad = Ad::where('id', $id)->first();
                if ($ad) {
                    $ad = $ad->toArray();
                    $data['addata'][$ad['type']] = unserialize($ad['data']);
                    unset($ad['data']);
                    $data['ad'] = $ad;
                }
            }

            return view('admin.common.ad_edit', $data);
        }
    }
}
