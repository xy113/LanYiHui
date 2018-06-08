<?php

namespace App\Models;

/**
 * App\Models\Resume
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResumeEdu[] $edus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResumeProject[] $projects
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResumeWork[] $works
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid
 * @property string $title
 * @property string $name
 * @property string $gender
 * @property int $age
 * @property string $phone
 * @property string $email
 * @property string $university
 * @property string $graduation_year 毕业年份
 * @property string $education 学历
 * @property string $major 所学专业
 * @property string $work_exp 工作经验
 * @property string $work_history 就职经历
 * @property string $introduction 个人介绍
 * @property string|null $status
 * @property int $views
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string|null $address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereGraduationYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereMajor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereUniversity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereWorkExp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resume whereWorkHistory($value)
 */
class Resume extends BaseModel
{
    protected $table = 'resume';
    protected $primaryKey = 'id';

    public function edus(){
        return $this->hasMany('App\Models\ResumeEdu');
    }
    public function works(){
        return $this->hasMany('App\Models\ResumeWork','resume_id');
    }
    public function projects(){
        return $this->hasMany('App\Models\ResumeProject','resume_id');
    }
}
