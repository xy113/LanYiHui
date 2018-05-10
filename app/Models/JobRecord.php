<?php

namespace App\Models;

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
