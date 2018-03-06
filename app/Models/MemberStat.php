<?php

namespace App\Models;

class MemberStat extends BaseModel
{
    protected $table = 'member_stat';
    protected $primaryKey = 'uid';
    public $timestamps = false;
}
