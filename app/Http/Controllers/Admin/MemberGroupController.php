<?php

namespace App\Http\Controllers\Admin;

use App\Models\MemberGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberGroupController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        if ($request->post('formsubmit') === 'yes'){
            $delete = $request->post('delete');
            if ($delete) {
                foreach ($delete as $gid) {
                    MemberGroup::where('gid', $gid)->delete();
                }
            }

            $grouplist = $request->post('grouplist');
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
            $grouplist = [];
            foreach (MemberGroup::all() as $g){
                $grouplist[$g->type][$g->gid] = $g->toArray();
            }
            return view('admin.member.group', ['grouplist'=>$grouplist]);
        }
    }
}
