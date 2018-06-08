<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-25
 * Time: 14:53
 */

namespace App\Models;

/**
 * App\Models\MemberEducation
 *
 * @property-read \App\Models\MemberArchive $archive
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid
 * @property string $school
 * @property string $major
 * @property string $degree
 * @property string $status
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberEducation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberEducation whereDegree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberEducation whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberEducation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberEducation whereMajor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberEducation whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberEducation whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberEducation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberEducation whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberEducation whereUpdatedAt($value)
 */
class MemberEducation extends BaseModel
{
    protected $table = 'member_education';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function archive(){
        return $this->belongsTo('App\Models\MemberArchive','uid','uid');
    }
}