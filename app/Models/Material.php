<?php

namespace App\Models;

/**
 * App\Models\Material
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid
 * @property string $username
 * @property int $albumid 专辑ID，图片素材有效
 * @property string|null $name
 * @property string|null $path
 * @property string|null $thumb
 * @property string|null $width
 * @property string|null $height
 * @property string|null $type
 * @property string|null $extension 扩展名
 * @property string|null $size
 * @property int $view_num
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereAlbumid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereViewNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Material whereWidth($value)
 */
class Material extends BaseModel
{
    protected $table = 'material';
    protected $primaryKey = 'id';
}
