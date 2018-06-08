<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-8
 * Time: 09:09
 */
namespace App\Models;

/**
 * App\Models\ResumeEdu
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $resume_id
 * @property string $school
 * @property string $degree
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $major
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeEdu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeEdu whereDegree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeEdu whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeEdu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeEdu whereMajor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeEdu whereResumeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeEdu whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeEdu whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeEdu whereUpdatedAt($value)
 */
class ResumeEdu extends BaseModel
{
    protected $table = 'resume_edu';
    protected $primaryKey = 'id';
}