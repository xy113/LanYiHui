<?php

namespace App\Http\Controllers\Admin;

use App\Models\WeixinMenu;
use App\WeChat\WxApi\WxMaterialApi;
use App\WeChat\WxApi\WxMenuApi;
use App\WeChat\WxApi\WxNewsApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WeixinController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function menu(Request $request){
        if ($this->isOnSubmit()) {
            $delete = $request->post('delete');
            if ($delete) {
                foreach ($delete as $id) {
                    WeixinMenu::where('id', $id)->delete();
                }
            }

            $menulist = $request->post('menulist');
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

            $data = [
                'menulist'=>[],
                'menu_types'=>trans('weixin.menu_types')
            ];

            $menulist = WeixinMenu::orderBy('displayorder', 'ASC')->orderBy('id', 'ASC')->get();
            if ($menulist) {
                foreach ($menulist as $menu) {
                    $menu->type_name = $data['menu_types'][$menu->type];
                    $data['menulist'][$menu->fid][$menu->id] = $menu->toArray();
                }
            }

            return view('admin.weixin.menu', $data);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function apply_menu(Request $request) {
        $menulist = [];
        foreach (WeixinMenu::orderBy('displayorder','ASC')->orderBy('id','ASC')->get() as $menu){
            $menulist[$menu->fid][$menu->id] = $menu->toArray();
        }
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function remove_menu(Request $request){
        $json = (new WxMenuApi())->delete();
        $res = json_decode($json, true);
        if ($res['errcode'] == 0) {
            return ajaxReturn();
        }else {
            return ajaxError(1, $json);
        }
    }

    /**
     * 编辑菜单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit_menu(Request $request) {
        $id = intval($request->input('id'));
        $fid = intval($request->input('fid'));
        if ($this->isOnSubmit()) {
            $menu = $request->post('menu');
            if ($id) {
                WeixinMenu::where('id', $id)->update($menu);
            }else {
                $menu['fid'] = $fid;
                WeixinMenu::insert($menu);
            }
            return ajaxReturn();
        }else {
            $data = [
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
            ];

            if ($id) {
                $menu = WeixinMenu::where('id', $id)->first();
                if ($menu) {
                    $data['menu'] = $menu->toArray();
                }
            }

            return view('admin.weixin.edit_menu', $data);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function material(Request $request) {
        $api = new WxMaterialApi();
        if ($this->isOnSubmit()) {
            $materials = $request->input('materials');
            foreach ($materials as $media_id) {
                $api->del($media_id);
            }
            return $this->showSuccess(trans('ui.delete_succeed'));
        }else {
            $type = $request->get('type');
            $type = $type ? $type : 'image';
            $data = [
                'material_types'=>trans('weixin.material_types'),
                'type'=>$type,
                'itemlist'=>[]
            ];

            $page = max(array(1, intval($request->get('page'))));
            $json = $api->batchget($type, ($page-1)*20, 20);
            $materials = json_decode($json, true);
            if (isset($materials['item'])) {
                $totalCount = $materials['total_count'];
                $data['itemlist'] = $materials['item'];
                $data['pagination'] = mutipage($page, 20, $totalCount, ['type'=>$type], false);

                return view('admin.weixin.material', $data);
            }else {
                return $json;
            }
        }
    }

    /**
     * @param Request $request
     */
    public function add_material(Request $request){

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function news(Request $request) {
        if ($this->isOnSubmit()) {
            $materials = $request->post('materials');
            $newsApi = new WxNewsApi();
            foreach ($materials as $media_id) {
                $newsApi->delete($media_id);
            }
            return $this->showSuccess(trans('ui.delete_succeed'));
        }else {
            $data = [
                'itemlist'=>[],
                'pagination'=>''
            ];
            $newsApi = new WxNewsApi();
            $page = max(array(1, intval($request->get('page'))));
            $json = $newsApi->batchget(($page - 1)*20, 20);
            $news = json_decode($json, true);
            if (isset($news['item'])) {
                $itemlist = $news['item'];
                $totalcount = $news['total_count'];
                $page = intval($request->get('page'));
                $data['pagination'] = mutipage($page, 20, $totalcount, null, false);

                if ($itemlist) {
                    $datalist = array();
                    foreach ($itemlist as $item){
                        $item['title'] = $item['content']['news_item'][0]['title'];
                        $item['thumb_media_id'] = $item['content']['news_item'][0]['thumb_media_id'];
                        $item['item_count'] = count($item['content']['news_item']);
                        unset($item['content']);
                        $datalist[$item['media_id']] = $item;
                    }
                    $data['itemlist'] = $datalist;
                }

                return view('admin.weixin.news', $data);
            }else {
                return $json;
            }

        }
    }

    /**
     * @param Request $request
     */
    public function add_news(Request $request){

    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function viewimage(Request $request){
        $media_id = $request->get('media_id');
        $api = new WxMaterialApi();
        return $api->get($media_id);
    }
}
