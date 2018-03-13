<?php

namespace App\Http\Controllers\Member;

use App\Models\Member;
use App\Models\MemberInfo;
use Illuminate\Http\Request;

class SettingsController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userinfo(Request $request){
        if ($this->isOnSubmit()) {
            $memberinfo = $request->post('memberinfo');
            MemberInfo::where('uid', $this->uid)->update($memberinfo);
            return $this->showSuccess(trans('ui.update_succeed'));
        }else {
            $this->appends([
                'menu'=>'userinfo',
                'memberinfo'=>MemberInfo::where('uid', $this->uid)->first()->toArray(),
                'sex_items'=>trans('member.sex_items')
            ]);
            return view('member.userinfo', $this->data);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function security(Request $request){
        if ($this->isOnSubmit()) {

        }else {
            $this->appends([
                'menu'=>'security',
                'member'=>Member::where('uid', $this->uid)->first()->toArray(),
            ]);

            return view('member.security', $this->data);
        }
    }

    /**
     *
     */
    public function verify(){
        if ($this->isOnSubmit()) {

        }else {

            return view('member.verify', $this->data);
        }
    }
}
