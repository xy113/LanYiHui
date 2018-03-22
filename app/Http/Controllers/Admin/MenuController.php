<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        if ($this->isOnSubmit()) {
            $delete = $this->request->post('delete');
            if ($delete) {
                foreach ($delete as $id){
                    Menu::where('id', $id)->delete();
                    Menu::where('menuid', $id)->delete();
                }
            }

            $menulist = $this->request->post('menulist');
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

            $this->data['menulist'] = [];
            Menu::where('type','menu')->get()->map(function ($menu){
                $this->data['menulist'][$menu->id] = $menu;
            });

            return view('admin.common.menu_list', $this->data);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemlist() {
        if ($this->isOnSubmit()) {
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {
            $menuid = $this->request->get('menuid');
            $this->appends([
                'menuid'=>$menuid,
                'menu'=>Menu::where('id', $menuid)->first(),
                'itemlist'=>Menu::where('menuid', $menuid)->get()
            ]);

            return view('admin.common.menu_items', $this->data);
        }
    }
}
