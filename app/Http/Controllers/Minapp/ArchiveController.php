<?php

namespace App\Http\Controllers\Minapp;

use App\Models\MemberArchive;

class ArchiveController extends BaseController
{
    public function get()
    {
        $archive = MemberArchive::where('uid', $this->uid)->first();
        return ajaxReturn(compact('archive'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function save()
    {
        $archive = $this->request->input('archive');
        //return ajaxReturn($archive);
        if ($archive) {
            $archive['username'] = $this->username;
            if (MemberArchive::where('uid', $this->uid)->exists()){
                $archive['updated_at'] = time();
                MemberArchive::where('uid', $this->uid)->update($archive);
            } else {
                $archive['uid'] = $this->uid;
                $archive['created_at'] = time();
                MemberArchive::insert($archive);
            }
        }

        return ajaxReturn();
    }
}
