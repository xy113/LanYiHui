<?php

namespace App\Models;

/**
 * App\Models\RecruitCatlog
 *
 * @mixin \Eloquent
 * @property int $catid
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitCatlog whereCatid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitCatlog whereName($value)
 */
class RecruitCatlog extends BaseModel
{
    protected $table = 'recruit_catlog';
    protected $primaryKey = 'catid';
}
