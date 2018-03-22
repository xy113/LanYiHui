<?php

namespace App\Http\Controllers\Admin;

use App\Models\MemberGroup;
use Illuminate\Http\Request;

class MemberGroupController extends BaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        if ($this->isOnSubmit()){
            $delete = $this->request->post('delete');
            if ($delete) {
                foreach ($delete as $gid) {
                    MemberGroup::where('gid', $gid)->delete();
                }
            }

            $grouplist = $this->request->post('grouplist');
            if ($grouplist) {
                foreach ($grouplist as $gid=>$group){
                    if ($group['title']) {
                        if ($gid > 0) {
                            MemberGroup::where('gid', $gid)->update($group);
                        }else {
                            MemberGroup::insert($group);
                        }
                    }
                }
            }
            return $this->showSuccess(trans('ui.update_succeed'));
        }else {

            $this->data['grouplist'] = [];
            MemberGroup::all()->map(function ($g){
                $this->data['grouplist'][$g->type][$g->gid] = $g;
            });

            return view('admin.member.group', $this->data);
        }
    }
}
