<?php

namespace App\Models;

class Member extends BaseModel
{
    protected $table = 'member';
    protected $primaryKey = 'uid';
    public $timestamps = false;

    /**
     * @param $uid
     */
    public static function deleteAll($uid){
        Member::where('uid', $uid)->delete();
        MemberToken::where('uid', $uid)->delete();
        MemberConnect::where('uid', $uid)->delete();
        MemberStatus::where('uid', $uid)->delete();
        MemberStat::where('uid', $uid)->delete();
        MemberLog::where('uid', $uid)->delete();
        MemberField::where('uid', $uid)->delete();
        MemberInfo::where('uid', $uid)->delete();
    }
}
