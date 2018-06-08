<?php

namespace App\Models;

/**
 * App\Models\PostLog
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $aid
 * @property string $title
 * @property int $uid
 * @property string $username
 * @property string $action_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostLog whereActionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostLog whereAid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostLog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostLog whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostLog whereUsername($value)
 */
class PostLog extends BaseModel
{
    protected $table = 'post_log';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
