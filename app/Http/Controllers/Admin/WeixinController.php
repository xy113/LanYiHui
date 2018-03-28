<?php

namespace App\Http\Controllers\Admin;

use App\Models\WeixinMenu;
use App\WeChat\WxApi\WxMaterialApi;
use App\WeChat\WxApi\WxMenuApi;
use App\WeChat\WxApi\WxNewsApi;

class WeixinController extends BaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function menu(){

        if ($this->isOnSubmit()) {
            $delete = $this->request->post('delete');
            if ($delete) {
                foreach ($delete as $id) {
                    WeixinMenu::where('id', $id)->delete();
                }
            }

            $menulist = $this->request->post('menulist');
            if ($menulist) {
                foreach ($menulist as $id=>$menu) {
                    if ($menu['name']) {
                        if ($id > 0) {
                            WeixinMenu::where('id', $id)->update($menu);
                        }else {
                            WeixinMenu::insert($menu);
                        }
                    }
                }
            }
            return $this->showSuccess(trans('ui.update_succeed'));
        }else {

            $this->assign([
                'menulist'=>[],
                'menu_types'=>trans('weixin.menu_types')
            ]);

            WeixinMenu::orderBy('displayorder', 'ASC')
                ->orderBy('id', 'ASC')->get()
                ->map(function ($menu){
                    $menu->type_name = $this->data['menu_types'][$menu->type];
                    $this->data['menulist'][$menu->fid][$menu->id] = $menu;
                });

            return $this->view('admin.weixin.menu');
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function apply_menu() {
        $menulist = [];
        WeixinMenu::orderBy('displayorder','ASC')->orderBy('id','ASC')->get()->map(function ($menu){
            $menulist[$menu->fid][$menu->id] = $menu->toArray();
        });

        if ($menulist) {
            $datalist = array();
            foreach ($menulist[0] as $menu){
                if (count($menulist[$menu['id']]) > 0){
                    $submenulist = array();
                    foreach ($menulist[$menu['id']] as $submenu){
                        if ($submenu['type'] == 'view'){
                            if ($submenu['name'] && $submenu['url']){
                                array_push($submenulist, array(
                                    'type'=>$submenu['type'],
                                    'name'=>urlencode($submenu['name']),
                                    'url'=>urlencode($submenu['url'])
                                ));
                            }
                        }elseif ($submenu['type'] == 'media_id' || $submenu['type'] == 'view_limited'){
                            if ($submenu['name'] && $submenu['media_id']){
                                array_push($submenulist, array(
                                    'type'=>$submenu['type'],
                                    'name'=>urlencode($submenu['name']),
                                    'media_id'=>urlencode($submenu['media_id'])
                                ));
                            }
                        }else{
                            if ($submenu['name'] && $submenu['key']){
                                array_push($submenulist, array(
                                    'type'=>$submenu['type'],
                                    'name'=>urlencode($submenu['name']),
                                    'key'=>urlencode($submenu['key'])
                                ));
                            }
                        }
                    }

                    array_push($datalist, array(
                        'name'=>urlencode($menu['name']),
                        'sub_button'=>$submenulist
                    ));
                }else {//无二级菜单
                    if ($menu['type'] == 'view'){
                        if ($menu['name'] && $menu['url']){
                            array_push($datalist, array(
                                'type'=>$menu['type'],
                                'name'=>urlencode($menu['name']),
                                'url'=>urlencode($menu['url'])
                            ));
                        }
                    }elseif ($menu['type'] == 'media_id' || $menu['type'] == 'view_limited'){
                        if ($menu['name'] && $menu['media_id']){
                            array_push($datalist, array(
                                'type'=>$menu['type'],
                                'name'=>urlencode($menu['name']),
                                'media_id'=>urlencode($menu['media_id'])

                            ));
                        }

                    }else{
                        if ($menu['name'] && $menu['key']){
                            array_push($datalist, array(
                                'type'=>$menu['type'],
                                'name'=>urlencode($menu['name']),
                                'key'=>urlencode($menu['key'])
                            ));
                        }
                    }
                }
            }
            $menulist = array('button'=>$datalist);
            $jsondata = json_encode($menulist);
            $jsondata = urldecode($jsondata);

            $api = new WxMenuApi();
            $json = $api->create($jsondata);
            $res = json_decode($json, true);
            if ($res['errcode'] == 0){
                return ajaxReturn();
            }else {
                return ajaxError(1, $json);
            }
        }else {
            return ajaxError(2, 'no menu');
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function remove_menu(){
        $json = (new WxMenuApi())->delete();
        $res = json_decode($json, true);
        if ($res['errcode'] == 0) {
            return ajaxReturn();
        }else {
            return ajaxError(1, $json);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit_menu() {
        $id = intval($this->request->input('id'));
        $fid = intval($this->request->input('fid'));
        if ($this->isOnSubmit()) {
            $menu = $this->request->post('menu');
            if ($id) {
                WeixinMenu::where('id', $id)->update($menu);
            }else {
                $menu['fid'] = $fid;
                WeixinMenu::insert($menu);
            }
            return ajaxReturn();
        }else {

            $this->assign([
                'fid'=>$fid,
                'menu'=>[
                    'fid'=>$fid,
                    'name'=>'',
                    'type'=>'view',
                    'url'=>'',
                    'media_id'=>'',
                    'key'=>''
                ],
                'menu_types'=>trans('weixin.menu_types')
            ]);

            $id && $this->data['menu'] = WeixinMenu::where('id', $id)->first();

            return $this->view('admin.weixin.edit_menu');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function material() {
        $api = new WxMaterialApi();
        if ($this->isOnSubmit()) {
            $materials = $this->request->input('materials');
            foreach ($materials as $media_id) {
                $api->del($media_id);
            }
            return $this->showSuccess(trans('ui.delete_succeed'));
        }else {
            $type = $this->request->get('type');
            $type = $type ? $type : 'image';
            $this->assign([
                'material_types'=>trans('weixin.material_types'),
                'type'=>$type,
                'itemlist'=>[]
            ]);

            $page = max(array(1, intval($this->request->get('page'))));
            $json = $api->batchget($type, ($page-1)*20, 20);
            $materials = json_decode($json, true);
            if (isset($materials['item'])) {
                $totalCount = $materials['total_count'];
                $this->data['itemlist'] = $materials['item'];
                $this->data['pagination'] = mutipage($page, 20, $totalCount, ['type'=>$type], false);

                return view('admin.weixin.material', $this->data);
            }else {
                return $json;
            }
        }
    }

    /**
     *
     */
    public function add_material(){

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function news() {
        if ($this->isOnSubmit()) {
            $materials = $this->request->post('materials');
            $newsApi = new WxNewsApi();
            foreach ($materials as $media_id) {
                $newsApi->delete($media_id);
            }
            return $this->showSuccess(trans('ui.delete_succeed'));
        }else {

            $this->assign([
                'itemlist'=>[],
                'pagination'=>''
            ]);
            $newsApi = new WxNewsApi();
            $page = max(array(1, intval($this->request->get('page'))));
            $json = $newsApi->batchget(($page - 1)*20, 20);
            $news = json_decode($json, true);
            if (isset($news['item'])) {
                $itemlist = $news['item'];
                $totalcount = $news['total_count'];
                $this->data['pagination'] = mutipage($page, 20, $totalcount, null, false);

                if ($itemlist) {
                    foreach ($itemlist as $item){
                        $item['title'] = $item['content']['news_item'][0]['title'];
                        $item['thumb_media_id'] = $item['content']['news_item'][0]['thumb_media_id'];
                        $item['item_count'] = count($item['content']['news_item']);
                        unset($item['content']);
                        $this->data['itemlist'][$item['media_id']] = $item;
                    }
                }

                return $this->view('admin.weixin.news');
            }else {
                return $json;
            }

        }
    }

    /**
     *
     */
    public function add_news(){

    }

    /**
     * @return mixed
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function viewimage(){
        $media_id = $this->request->get('media_id');
        $api = new WxMaterialApi();
        return $api->get($media_id);
    }
}
