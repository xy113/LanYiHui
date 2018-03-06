<?php

namespace App\Models;

class MemberSession extends BaseModel
{
    protected $table = 'member_session';
    protected $primaryKey = 'uid';
    public $timestamps = false;
}
