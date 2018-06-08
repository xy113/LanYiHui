<?php

namespace App\Models;

/**
 * App\Models\MemberSession
 *
 * @mixin \Eloquent
 * @property int $uid
 * @property string $session_key
 * @property string $session_value
 * @property string $expire_time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSession whereExpireTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSession whereSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSession whereSessionValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSession whereUid($value)
 */
class MemberSession extends BaseModel
{
    protected $table = 'member_session';
    protected $primaryKey = 'uid';
    public $timestamps = false;
}
