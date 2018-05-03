<?php

namespace App\Models;

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
