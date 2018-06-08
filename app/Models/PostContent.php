<?php

namespace App\Models;

/**
 * App\Models\PostContent
 *
 * @mixin \Eloquent
 * @property int $aid
 * @property int $uid
 * @property string $content
 * @property int $pageorder
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostContent whereAid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostContent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostContent wherePageorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostContent whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostContent whereUpdatedAt($value)
 */
class PostContent extends BaseModel
{
    protected $table = 'post_content';
    protected $primaryKey = 'aid';
    public $timestamps = false;
}
