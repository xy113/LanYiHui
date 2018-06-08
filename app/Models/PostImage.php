<?php

namespace App\Models;

/**
 * App\Models\PostImage
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $aid 数据ID
 * @property int $uid
 * @property string $image
 * @property string $thumb
 * @property int $isremote
 * @property string $description
 * @property int $displayorder
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostImage whereAid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostImage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostImage whereDisplayorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostImage whereIsremote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostImage whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostImage whereUid($value)
 */
class PostImage extends BaseModel
{
    protected $table = 'post_image';
    protected $primaryKey = 'aid';
    public $timestamps = false;
}
