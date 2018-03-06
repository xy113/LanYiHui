<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        if ($this->isOnSubmit()) {
            $delete = $request->post('delete');
            if ($delete) {
                foreach ($delete as $id){
                    Menu::where('id', $id)->delete();
                    Menu::where('menuid', $id)->delete();
                }
            }

            $menulist = $request->post('menulist');
            if ($menulist) {
                foreach ($menulist as $id=>$menu) {
                    if ($menu['name']) {
                        if ($id > 0) {
                            Menu::where('id', $id)->update($menu);
                        }else {
                            Menu::insert($menu);
                        }
                    }
                }
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {
            $menulist = [];
            foreach (Menu::where('type','menu')->get() as $menu){
                $menulist[$menu->id] = $menu->toArray();
            }
            return view('admin.common.menu_list', ['menulist'=>$menulist]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemlist(Request $request) {
        if ($this->isOnSubmit()) {
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {
            $menuid = intval($request->get('menuid'));
            $data = [
                'menuid'=>$menuid,
                'menu'=>[],
                'itemlist'=>[]
            ];

            $menu = Menu::where('id', $menuid)->first();
            if ($menu) $data['menu'] = $menu->toArray();
            return view('admin.common.menu_items', $data);
        }
    }
}
