<?php

namespace App\Models;

/**
 * App\Models\MemberField
 *
 * @mixin \Eloquent
 * @property int $field_id
 * @property int $uid
 * @property string $field
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberField whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberField whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberField whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberField whereValue($value)
 */
class MemberField extends BaseModel
{
    protected $table = 'member_field';
    protected $primaryKey = 'field_id';
    public $timestamps = false;
}
