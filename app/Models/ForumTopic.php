<?php

namespace App\Models;

/**
 * App\Models\ForumTopic
 *
 * @mixin \Eloquent
 * @property int $tid
 * @property int $boardid
 * @property int $uid
 * @property string $username
 * @property string $title
 * @property int $last_uid
 * @property string $last_username
 * @property string $created_at
 * @property string $updated_at
 * @property int $toplevel
 * @property int $replies
 * @property int $views
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumTopic whereBoardid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumTopic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumTopic whereLastUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumTopic whereLastUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumTopic whereReplies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumTopic whereTid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumTopic whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumTopic whereToplevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumTopic whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumTopic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumTopic whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumTopic whereViews($value)
 */
class ForumTopic extends BaseModel
{
    protected $table = 'forum_topic';
    protected $primaryKey = 'tid';
}
