<?php

namespace App\Models;

/**
 * App\Models\MemberStat
 *
 * @mixin \Eloquent
 * @property int $uid
 * @property int $postnum
 * @property int $commentnum
 * @property int $albumnum
 * @property int $photonum
 * @property int $follower
 * @property int $following
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStat whereAlbumnum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStat whereCommentnum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStat whereFollower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStat whereFollowing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStat wherePhotonum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStat wherePostnum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberStat whereUid($value)
 */
class MemberStat extends BaseModel
{
    protected $table = 'member_stat';
    protected $primaryKey = 'uid';
    public $timestamps = false;
}
