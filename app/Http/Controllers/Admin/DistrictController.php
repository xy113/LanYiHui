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
    public function index(){
        $province = intval($this->request->get('province'));
        $city     = intval($this->request->get('city'));
        $district = intval($this->request->get('district'));

        $this->appends([
            'province'=>$province,
            'city'=>$city,
            'district'=>$district,
            'provincelist'=>[],
            'citylist'=>[],
            'districtlist'=>[],
            'itemlist'=>[]
        ]);

        $provincelist = District::where('fid', 0)->orderBy('displayorder', 'ASC')->orderBy('id', 'ASC')->get();
        if ($provincelist) {
            foreach ($provincelist as $p){
                $this->data['provincelist'][$p->id] = $p;
            }
            $this->data['itemlist'] = $this->data['provincelist'];
        }

        if ($province) {
            $citylist = District::where('fid', $province)->orderBy('displayorder', 'ASC')->orderBy('id', 'ASC')->get();
            if ($citylist) {
                foreach ($citylist as $c){
                    $this->data['citylist'][$c->id] = $c;
                }
            }
            $this->data['itemlist'] = $this->data['citylist'];
        }

        if ($city) {
            $districtlist = District::where('fid', $city)->orderBy('displayorder', 'ASC')->orderBy('id', 'ASC')->get();
            if ($districtlist) {
                foreach ($districtlist as $d) {
                    $this->data['districtlist'][$d->id] = $d;
                }
            }
            $this->data['itemlist'] = $this->data['districtlist'];
        }


        if ($district) {
            $townlist = District::where('fid', $district)->orderBy('displayorder', 'ASC')->orderBy('id', 'ASC')->get();
            if ($townlist) {
                foreach ($townlist as $t){
                    $this->data['itemlist'][$t->id] = $t;
                }
            }
        }

        return view('admin.common.district', $this->data);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(){
        $delete = $this->request->input('delete');
        if ($delete) {
            foreach ($delete as $id) {
                District::where('id', $id)->delete();
            }
        }

        $itemlist = $this->request->input('itemlist');
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
