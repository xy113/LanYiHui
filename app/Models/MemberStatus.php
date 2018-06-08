<?php

namespace App\Models;

/**
 * App\Models\MemberStatus
 *
 * @mixin \Eloquent
 * @property int $uid
 * @property string $regdate
 * @property string $regip
 * @property string $lastvisit
 * @property string $lastvisitip
 * @property string $lastactive
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStatus whereLastactive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStatus whereLastvisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStatus whereLastvisitip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStatus whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStatus whereRegip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStatus whereUid($value)
 */
class MemberStatus extends BaseModel
{
    protected $table = 'member_status';
    protected $primaryKey = 'uid';
    public $timestamps = false;
}
