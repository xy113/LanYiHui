<?php

namespace App\Models;

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
