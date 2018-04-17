<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-12
 * Time: 08:44
 */
namespace App\Models;

class Schoolfellow extends BaseModel
{
    protected $table = 'schoolfellow';
    protected $primaryKey = 'id';
    public function user(){
        return $this->hasOne('App\Models\Member','uid','uid');
    }
    public function school(){
        return $this->hasOne('App\Models\School');
    }
}