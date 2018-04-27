<?php

namespace App\Models;

class MemberArchive extends BaseModel
{
    protected $table = 'member_archive';
    protected $primaryKey = 'id';
    public function experience(){
        return $this->hasMany('App\Models\MemberExperience','uid','uid');
    }
    public function education(){
        return $this->hasMany('App\Models\MemberEducation','uid','uid');
    }
    public function work(){
        return $this->hasMany('App\Models\MemberWork','uid','uid');
    }
}
