<?php

namespace App\Models;

class MemberGroup extends BaseModel
{
    protected $table = 'member_group';
    protected $primaryKey = 'gid';
    public $timestamps = false;
}
