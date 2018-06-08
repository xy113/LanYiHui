<?php

namespace App\Models;

/**
 * App\Models\Collection
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid
 * @property int $data_id
 * @property string $data_type
 * @property string $title
 * @property string $image
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Collection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Collection whereDataId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Collection whereDataType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Collection whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Collection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Collection whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Collection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Collection whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Collection whereUpdatedAt($value)
 */
class Collection extends BaseModel
{
    protected $table = 'collection';
    protected $primaryKey = 'id';
}
