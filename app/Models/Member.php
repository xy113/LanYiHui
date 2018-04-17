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

    public function schools()
    {
        return $this->belongsToMany('App\Models\School','schoolfellow','uid','school_id');
    }
    public function apply(){
        return $this->belongsToMany('App\Models\School','schoolfellow','uid','school_id')->withPivot('degree', 'major','created_at')->wherePivot('status','0');
    }
    public function refused(){
        return $this->belongsToMany('App\Models\School','schoolfellow','uid','school_id')->wherePivot('status','-1');
    }
    public function entered(){
        return $this->belongsToMany('App\Models\School','schoolfellow','uid','school_id')->withPivot('degree', 'major','created_at')->wherePivot('status','1');
    }
    public function info(){
        return $this->hasOne('App\Models\MemberInfo','uid','uid');
    }
}
