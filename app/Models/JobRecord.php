<?php

namespace App\Models;

/**
 * App\Models\JobRecord
 *
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\Job $job
 * @property-read \App\Models\Resume $resume
 * @mixin \Eloquent
 * @property int $id
 * @property int $job_id
 * @property int $uid
 * @property string $username
 * @property int $resume_id
 * @property string $fullname
 * @property string $status 0:已提交，1：已查看； 2：已通过；-1：已拒绝；3：预留位
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $company_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobRecord whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobRecord whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobRecord whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobRecord whereResumeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobRecord whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobRecord whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobRecord whereUsername($value)
 */
class JobRecord extends BaseModel
{
    protected $table = 'job_record';
    protected $primaryKey = 'id';

    public function resume(){
        return $this->hasOne('App\Models\Resume','id','resume_id');
    }
    public function job(){
        return $this->hasOne('App\Models\Job','job_id','job_id');
    }
    public function company(){
        return $this->hasOne('App\Models\Company','company_id','company_id');
    }
}
