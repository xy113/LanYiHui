<?php

namespace App\Models;

class MemberStatus extends BaseModel
{
    protected $table = 'member_status';
    protected $primaryKey = 'uid';
    public $timestamps = false;
}
