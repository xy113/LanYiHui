<?php

namespace App\Http\Controllers\Member;

use App\Models\Member;
use App\Models\MemberArchive;
use App\Models\MemberInfo;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

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
            $this->assign([
                'menu'=>'userinfo',
                'memberinfo'=>MemberInfo::where('uid', $this->uid)->first()->toArray(),
                'sex_items'=>trans('member.sex_items')
            ]);

            return $this->view('member.settings.userinfo');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function security(Request $request){
        if ($this->isOnSubmit()) {

        }else {
            $this->assign([
                'menu'=>'security',
                'member'=>Member::where('uid', $this->uid)->first()->toArray(),
            ]);

            return $this->view('member.settings.security');
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function set_avatar(){

        $avatarPath = storage_public_path('avatar/'.$this->uid);
        @mkdir($avatarPath, 0777, true);
        $source = storage_public_path($this->request->file('file')->store('tmp'));

        $image = Image::make($source);
        $width = $image->width();
        $height = $image->height();
        if ($width > $height) {
            $x = ($width - $height)/2;
            $image = $image->crop($height, $height, intval($x), 0);
        }else {
            $y = ($height - $width)/2;
            $image = $image->crop($width, $width, 0, intval($y));
        }

        $image->resize(300, 300)->save($avatarPath.'/big.png');
        $image->resize(150, 150)->save($avatarPath.'/middle.png');
        $image->resize(50, 50)->save($avatarPath.'/small.png');
        @unlink($source);

        return ajaxReturn();
    }

    public function archive(){

        if ($this->isOnSubmit()) {

        }else {

            $archive = MemberArchive::where('uid', $this->uid)->first();
            $this->assign([
                'archive'=>$archive,
                'menu'=>'archive',
                'verify_status'=>trans('member.verify_status')
            ]);

            return $this->view('member.settings.archive');
        }
    }
}
