<?php

namespace App\Models;

/**
 * App\Models\Block
 *
 * @mixin \Eloquent
 * @property int $block_id
 * @property string $block_name
 * @property string $block_desc
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Block whereBlockDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Block whereBlockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Block whereBlockName($value)
 */
class Block extends BaseModel
{
    protected $table = 'block';
    protected $primaryKey = 'block_id';
    public $timestamps = false;
}
