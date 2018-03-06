<?php

namespace App\Models;

class MemberInfo extends BaseModel
{
    protected $table = 'member_info';
    protected $primaryKey = 'uid';
    public $timestamps = false;
}
