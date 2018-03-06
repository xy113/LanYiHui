<?php

namespace App\Models;

class PostContent extends BaseModel
{
    protected $table = 'post_content';
    protected $primaryKey = 'aid';
    public $timestamps = false;
}
