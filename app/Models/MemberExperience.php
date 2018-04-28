<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-25
 * Time: 14:53
 */

namespace App\Models;

class MemberExperience extends BaseModel
{
    protected $table = 'member_experience';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function archive(){
        return $this->belongsTo('App\Models\MemberArchive','uid','uid');
    }
}