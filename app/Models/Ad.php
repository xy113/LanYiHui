<?php

namespace App\Models;

/**
 * App\Models\Ad
 *
 * @mixin \Eloquent
 * @property int $id ID
 * @property int $uid
 * @property string $title 标题
 * @property string $type
 * @property string $begin_time
 * @property string $end_time
 * @property string $data
 * @property int $click_num
 * @property int $available 是否可用
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereBeginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereClickNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereUpdatedAt($value)
 */
class Ad extends BaseModel
{
    protected $table = 'ad';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
