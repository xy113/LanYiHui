<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Pinyin;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends BaseController
{
    /**
     *
     */
    public function index(Request $request){
        $province = intval($request->get('province'));
        $city     = intval($request->get('city'));
        $district = intval($request->get('district'));

        $data = [
            'province'=>$province,
            'city'=>$city,
            'district'=>$district,
            'provincelist'=>[],
            'citylist'=>[],
            'districtlist'=>[],
            'itemlist'=>[]
        ];

        $provincelist = District::where('fid', 0)->orderBy('displayorder', 'ASC')->orderBy('id', 'ASC')->get();
        if ($provincelist) {
            foreach ($provincelist as $p){
                $data['provincelist'][$p->id] = $p->toArray();
            }
            $data['itemlist'] = $data['provincelist'];
        }

        if ($province) {
            $citylist = District::where('fid', $province)->orderBy('displayorder', 'ASC')->orderBy('id', 'ASC')->get();
            if ($citylist) {
                foreach ($citylist as $c){
                    $data['citylist'][$c->id] = $c->toArray();
                }
            }
            $data['itemlist'] = $data['citylist'];
        }

        if ($city) {
            $districtlist = District::where('fid', $city)->orderBy('displayorder', 'ASC')->orderBy('id', 'ASC')->get();
            if ($districtlist) {
                foreach ($districtlist as $d) {
                    $data['districtlist'][$d->id] = $d->toArray();
                }
            }
            $data['itemlist'] = $data['districtlist'];
        }


        if ($district) {
            $townlist = District::where('fid', $district)->orderBy('displayorder', 'ASC')->orderBy('id', 'ASC')->get();
            if ($townlist) {
                foreach ($townlist as $t){
                    $data['itemlist'][$t->id] = $t->toArray();
                }
            }
        }

        return view('admin.common.district', $data);
    }


    public function save(Request $request){
        $delete = $request->input('delete');
        if ($delete) {
            foreach ($delete as $id) {
                District::where('id', $id)->delete();
            }
        }

        $itemlist = $request->input('itemlist');
        if ($itemlist) {
            $pinyin = new Pinyin();
            foreach ($itemlist as $id=>$item){
                $item = rejectNullValues($item);
                if (!$item['letter']){
                    $item['letter'] = $pinyin->getFirstChar($item['name']);
                }

                if (!$item['pinyin']){
                    $item['pinyin'] = $pinyin->getPinyin($item['name']);
                }
                if ($item['name']) {
                    if ($id > 0) {
                        District::where('id', $id)->update($item);
                    }else {
                        District::insert($item);
                    }
                }
            }
        }
        return $this->showSuccess(trans('ui.save_succeed'));
    }
}
