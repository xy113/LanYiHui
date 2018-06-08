<?php

namespace App\Models;

/**
 * App\Models\PostComment
 *
 * @mixin \Eloquent
 * @property int $commid
 * @property int $aid
 * @property int $uid
 * @property string $username
 * @property int $reply_uid
 * @property string $reply_name
 * @property string $message
 * @property string $province
 * @property string $city
 * @property string $street
 * @property int $likes
 * @property int $status 审核状态
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereAid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereCommid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereReplyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereReplyUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComment whereUsername($value)
 */
class PostComment extends BaseModel
{
    protected $table = 'post_comment';
    protected $primaryKey = 'commid';
    public $timestamps = false;
}
