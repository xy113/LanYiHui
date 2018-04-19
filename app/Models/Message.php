<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-17
 * Time: 11:04
 */
namespace App\Models;

class Message extends BaseModel
{
    protected $table = 'message';
    protected $primaryKey = 'id';
    public function school(){
        return $this->hasOne('App\Models\School');
    }
    public function owner(){
        return $this->hasOne('App\Models\Member','uid','uid');
    }
    public function visitor(){
        return $this->hasOne('App\Models\Member','uid','vid');
    }
    public function parent(){
        return $this->hasOne('App\Models\Message','id','parent_id');
    }
    public function reply(){
        return $this->hasOne('App\Models\Message','id','reply_id');
    }
    public function children(){
        return $this->hasMany('App\Models\Message','parent_id','id');
    }
}