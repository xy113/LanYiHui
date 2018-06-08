<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-25
 * Time: 14:53
 */

namespace App\Models;

/**
 * App\Models\MemberExperience
 *
 * @property-read \App\Models\MemberArchive $archive
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid
 * @property string|null $year
 * @property string $vacation
 * @property string $part
 * @property string|null $department
 * @property string $role
 * @property string|null $description
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberExperience whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberExperience whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberExperience whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberExperience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberExperience wherePart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberExperience whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberExperience whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberExperience whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberExperience whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberExperience whereVacation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberExperience whereYear($value)
 */
class MemberExperience extends BaseModel
{
    protected $table = 'member_experience';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function archive(){
        return $this->belongsTo('App\Models\MemberArchive','uid','uid');
    }
}