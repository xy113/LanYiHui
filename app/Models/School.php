<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-8
 * Time: 09:11
 */
namespace App\Models;

class School extends BaseModel
{
    protected $table = 'School';
    protected $primaryKey = 'id';
    public function members(){
        return $this->belongsToMany('App\Models\Member','schoolfellow','school_id','uid')->withPivot(['id','major','graduation_at','degree'])->withTimestamps()->wherePivot('status','1');
    }
    public function apply(){
        return $this->belongsToMany('App\Models\Member','schoolfellow','school_id','uid')->wherePivot('status','0')->withPivot(['id','major','graduation_at','degree'])->withTimestamps();
    }
    public function refused(){
        return $this->belongsToMany('App\Models\Member','schoolfellow','school_id','uid')->wherePivot('status','-1');
    }
}