<?php

namespace App\Models;

/**
 * App\Models\Link
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $catid
 * @property string $type
 * @property string $title
 * @property string $url
 * @property string $image
 * @property int $displayorder
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereCatid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereDisplayorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereUrl($value)
 */
class Link extends BaseModel
{
    protected $table = 'link';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
