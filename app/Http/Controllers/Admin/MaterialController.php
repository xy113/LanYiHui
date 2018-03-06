<?php

namespace App\Http\Controllers\Admin;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){

        $data = [
            'itemlist'=>[],
            'pagination'=>'',
            'material_types'=>trans('common.material_types')
        ];

        $condition = $queryParams = array();

        $type = $request->get('type');
        $type = $type ? $type : 'image';
        $condition[] = ['type', '=', $type];
        $queryParams['type'] = $type;
        $data['type'] = $type;

        $uid = $request->input('uid');
        $data['uid'] = $uid;
        if ($uid) {
            $condition[] = ['uid', '=', $uid];
            $queryParams['uid'] = $uid;
        }

        $username = $request->input('username');
        $data['username'] = $username;
        if ($username) {
            $condition[] = ['username', '=', $username];
            $queryParams['username'] = $username;
        }

        $name = $request->input('name');
        $data['name'] = $name;
        if ($name) {
            $condition[] = ['name', 'LIKE', $name];
            $queryParams['name'] = $name;
        }

        $time_begin = $request->input('time_begin');
        $data['time_begin'] = $time_begin;
        if ($time_begin) {
            $condition[] = ['created_at', '>', strtotime($time_begin)];
            $queryParams['time_begin'] = $time_begin;
        }

        $time_end = $request->input('time_end');
        $data['time_end'] = $time_end;
        if ($time_end) {
            $condition[] = ['created_at', '<', strtotime($time_end)];
            $queryParams['time_end'] = $time_end;
        }

        $materials = Material::where($condition)->orderBy('id', 'DESC')->paginate(20);
        $data['pagination'] = $materials->appends($queryParams)->links();

        foreach ($materials as $m){
            $data['itemlist'][$m->id] = $m->toArray();
        }
        //print_array($data);exit();
        return view('admin.common.material', $data);
    }

    /**
     *
     */
    public function delete(Request $request){
        $materials = $request->input('materials');
        foreach (Material::whereIn('id', $materials)->get() as $m){
            @unlink(storage_public_path($m->thumb));
            @unlink(storage_public_path($m->path));
            Material::where('id', $m->id)->delete();
        }
        return ajaxReturn();
    }
}
