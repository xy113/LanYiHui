<?php

namespace App\Models;

/**
 * App\Models\WeixinMenu
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $fid
 * @property string $name
 * @property string $type
 * @property string $key
 * @property string $media_id
 * @property string $url
 * @property int $displayorder
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WeixinMenu whereDisplayorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WeixinMenu whereFid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WeixinMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WeixinMenu whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WeixinMenu whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WeixinMenu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WeixinMenu whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WeixinMenu whereUrl($value)
 */
class WeixinMenu extends BaseModel
{
    protected $table = 'weixin_menu';
    protected $primaryKey = 'id';
}
