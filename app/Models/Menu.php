<?php

namespace App\Models;

/**
 * App\Models\Menu
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $menuid
 * @property int $fid
 * @property string $name
 * @property string $url
 * @property string $type
 * @property string $icon
 * @property string $target
 * @property int $displayorder
 * @property int $available
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereDisplayorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereFid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereMenuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereUrl($value)
 */
class Menu extends BaseModel
{
    protected $table = 'menu';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
