<?php

namespace App\Models;

/**
 * App\Models\Job
 *
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobRecord[] $records
 * @mixin \Eloquent
 * @property int $job_id
 * @property int $company_id
 * @property string $title
 * @property int $type
 * @property string $salary 薪资范围
 * @property int $num 招聘人数
 * @property string $place 工作地点
 * @property string $welfare 福利待遇
 * @property string $description 职位描述
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $view_num
 * @property int $collection_num
 * @property string|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereCollectionNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereViewNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereWelfare($value)
 */
class Job extends BaseModel
{
    protected $table = 'job';
    protected $primaryKey = 'job_id';

    public function records(){
        return $this->hasMany('App\Models\JobRecord','job_id','job_id');
    }
    public function company(){
        return $this->hasOne('App\Models\Company','company_id','company_id');
    }
}
