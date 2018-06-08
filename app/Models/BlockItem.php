<?php

namespace App\Models;

/**
 * App\Models\BlockItem
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $block_id
 * @property string $title 标题
 * @property string $image 图片
 * @property string $url 链接
 * @property string $subtitle 副标题
 * @property string $field_1
 * @property string $field_2
 * @property string $field_3
 * @property int $displayorder 显示顺序
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockItem whereBlockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockItem whereDisplayorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockItem whereField1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockItem whereField2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockItem whereField3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockItem whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockItem whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockItem whereUrl($value)
 */
class BlockItem extends BaseModel
{
    protected $table = 'block_item';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
