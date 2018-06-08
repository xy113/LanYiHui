<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-8
 * Time: 09:11
 */
namespace App\Models;

/**
 * App\Models\ResumeWork
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $resume_id
 * @property string $company
 * @property string $job
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string $experience
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeWork whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeWork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeWork whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeWork whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeWork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeWork whereJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeWork whereResumeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeWork whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResumeWork whereUpdatedAt($value)
 */
class ResumeWork extends BaseModel
{
    protected $table = 'resume_work';
    protected $primaryKey = 'id';
}