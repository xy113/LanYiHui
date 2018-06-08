<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-8
 * Time: 09:11
 */
namespace App\Models;

/**
 * App\Models\School
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Member[] $apply
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Member[] $members
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Member[] $refused
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereUpdatedAt($value)
 */
class School extends BaseModel
{
    protected $table = 'School';
    protected $primaryKey = 'id';
    public function members(){
        return $this->belongsToMany('App\Models\Member','schoolfellow','school_id','uid')->withPivot(['id','major','graduation_at','degree'])->withTimestamps()->wherePivot('status','1');
    }
    public function apply(){
        return $this->belongsToMany('App\Models\Member','schoolfellow','school_id','uid')->wherePivot('status','0')->withPivot(['id','major','graduation_at','degree'])->withTimestamps();
    }
    public function refused(){
        return $this->belongsToMany('App\Models\Member','schoolfellow','school_id','uid')->wherePivot('status','-1');
    }
}