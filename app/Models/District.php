<?php

namespace App\Models;


/**
 * App\Models\District
 *
 * @mixin \Eloquent
 * @property int $id ID
 * @property int $fid 父级ID
 * @property string $name 名称
 * @property int $level 级别
 * @property int $usetype 使用类型
 * @property int $displayorder 排序
 * @property string $zone_code
 * @property float $lng
 * @property float $lat
 * @property string $pinyin
 * @property string $letter
 * @property string $citycode 区号
 * @property string $zipcode 邮编
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereCitycode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereDisplayorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereFid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District wherePinyin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereUsetype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereZipcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereZoneCode($value)
 */
class District extends BaseModel
{
    protected $table = 'district';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
