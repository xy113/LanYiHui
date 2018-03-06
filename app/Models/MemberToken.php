<?php

namespace App\Models;

class MemberToken extends BaseModel
{
    protected $table = 'member_token';
    protected $primaryKey = 'uid';
    public $timestamps = false;
}
