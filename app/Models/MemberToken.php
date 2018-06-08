<?php

namespace App\Models;

/**
 * App\Models\MemberToken
 *
 * @mixin \Eloquent
 * @property int $uid 用户ID
 * @property string $token 令牌
 * @property string $expire_time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberToken whereExpireTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberToken whereUid($value)
 */
class MemberToken extends BaseModel
{
    protected $table = 'member_token';
    protected $primaryKey = 'uid';
    public $timestamps = false;
}
