<?php

namespace App\Models;

/**
 * App\Models\Member
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\School[] $apply
 * @property-read \App\Models\MemberArchive $archive
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\School[] $entered
 * @property-read \App\Models\MemberInfo $info
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\School[] $refused
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\School[] $schools
 * @mixin \Eloquent
 * @property int $uid
 * @property int $gid
 * @property int $adminid 管理员ID
 * @property int $admincp 是否允许登录后台
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $email 邮箱
 * @property string $mobile 手机号
 * @property int $status 状态
 * @property int $newpm 新消息
 * @property int $emailstatus 邮箱验证状态
 * @property int $avatarstatus 头像验证状态
 * @property int $freeze 冻结账户
 * @property int $exp 经验值，积分
 * @property int $exp1
 * @property int $exp2
 * @property int $exp3
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereAdmincp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereAdminid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereAvatarstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereEmailstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereExp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereExp1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereExp2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereExp3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereFreeze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereGid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereNewpm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereUsername($value)
 */
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
    public function archive(){
        return $this->hasOne('App\Models\MemberArchive','uid','uid');
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
