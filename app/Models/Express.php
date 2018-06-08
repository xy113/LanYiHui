<?php

namespace App\Models;

/**
 * App\Models\Express
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $regular
 * @property int $displayorder
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Express whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Express whereDisplayorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Express whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Express whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Express whereRegular($value)
 */
class Express extends BaseModel
{
    protected $table = 'express';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
