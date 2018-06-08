<?php

namespace App\Models;

/**
 * App\Models\ForumMessage
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $tid
 * @property int $boardid
 * @property int $uid
 * @property string $username
 * @property string $message
 * @property string $created_at
 * @property string $updated_at
 * @property int $topic
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumMessage whereBoardid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumMessage whereTid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumMessage whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumMessage whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumMessage whereUsername($value)
 */
class ForumMessage extends BaseModel
{
    protected $table = 'forum_message';
    protected $primaryKey = 'id';
}
