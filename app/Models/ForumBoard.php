<?php

namespace App\Models;

/**
 * App\Models\ForumBoard
 *
 * @mixin \Eloquent
 * @property int $boardid
 * @property int $uid
 * @property string $username
 * @property string $title
 * @property string $icon
 * @property int $displayorder
 * @property int $visible
 * @property string $created_at
 * @property string $updated_at
 * @property int $views
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumBoard whereBoardid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumBoard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumBoard whereDisplayorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumBoard whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumBoard whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumBoard whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumBoard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumBoard whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumBoard whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ForumBoard whereVisible($value)
 */
class ForumBoard extends BaseModel
{
    protected $table = 'forum_board';
    protected $primaryKey = 'boardid';
}
