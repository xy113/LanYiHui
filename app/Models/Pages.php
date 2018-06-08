<?php

namespace App\Models;

/**
 * App\Models\Pages
 *
 * @mixin \Eloquent
 * @property int $pageid
 * @property string $type
 * @property int $catid
 * @property string $title
 * @property string $alias
 * @property string $image
 * @property string $summary
 * @property string $body
 * @property string $template
 * @property int $displayorder
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereCatid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereDisplayorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages wherePageid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereUpdatedAt($value)
 */
class Pages extends BaseModel
{
    protected $table = 'pages';
    protected $primaryKey = 'pageid';
    public $timestamps = true;

}
