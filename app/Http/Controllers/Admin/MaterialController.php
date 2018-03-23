<?php

namespace App\Http\Controllers\Admin;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $this->data['material_types'] = trans('common.material_types');

        $condition = $queryParams = [];

        $type = $this->request->get('type');
        $type = $type ? $type : 'image';
        $this->data['type'] = $type;
        $condition[] = ['type', '=', $type];
        $queryParams['type'] = $type;

        $uid = $this->request->input('uid');
        $this->data['uid'] = $uid;
        if ($uid) {
            $condition[] = ['uid', '=', $uid];
            $queryParams['uid'] = $uid;
        }

        $username = $this->request->input('username');
        $this->data['username'] = $username;
        if ($username) {
            $condition[] = ['username', '=', $username];
            $queryParams['username'] = $username;
        }

        $name = $this->request->input('name');
        $this->data['name'] = $name;
        if ($name) {
            $condition[] = ['name', 'LIKE', "%$name%"];
            $queryParams['name'] = $name;
        }

        $time_begin = $this->request->input('time_begin');
        $this->data['time_begin'] = $time_begin;
        if ($time_begin) {
            $condition[] = ['created_at', '>', strtotime($time_begin)];
            $queryParams['time_begin'] = $time_begin;
        }

        $time_end = $this->request->input('time_end');
        $this->data['time_end'] = $time_end;
        if ($time_end) {
            $condition[] = ['created_at', '<', strtotime($time_end)];
            $queryParams['time_end'] = $time_end;
        }

        $materials = Material::where($condition)->orderBy('id', 'DESC')->paginate(20);
        $this->data['pagination'] = $materials->appends($queryParams)->links();

        $this->data['itemlist'] = [];
        $materials->map(function ($m){
            $this->data['itemlist'][$m->id] = $m;
        });

        return $this->view('admin.common.material');
    }

    /**
     *
     */
    public function delete(){
        $materials = $this->request->input('materials');
        foreach (Material::whereIn('id', $materials)->get() as $m){
            @unlink(storage_public_path($m->thumb));
            @unlink(storage_public_path($m->path));
            Material::where('id', $m->id)->delete();
        }
        return ajaxReturn();
    }
}
