<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-12
 * Time: 08:44
 */
namespace App\Models;

/**
 * App\Models\Schoolfellow
 *
 * @property-read \App\Models\School $school
 * @property-read \App\Models\Member $user
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid
 * @property int $school_id
 * @property string|null $graduation_at
 * @property string|null $degree
 * @property string|null $major
 * @property string|null $status -1:拒绝，0：申请中， 1：通过
 * @property string|null $reason
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schoolfellow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schoolfellow whereDegree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schoolfellow whereGraduationAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schoolfellow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schoolfellow whereMajor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schoolfellow whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schoolfellow whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schoolfellow whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schoolfellow whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schoolfellow whereUpdatedAt($value)
 */
class Schoolfellow extends BaseModel
{
    protected $table = 'schoolfellow';
    protected $primaryKey = 'id';
    public function user(){
        return $this->hasOne('App\Models\Member','uid','uid');
    }
    public function school(){
        return $this->hasOne('App\Models\School');
    }
}