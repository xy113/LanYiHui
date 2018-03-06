<?php

namespace App\Models;

class PostComment extends BaseModel
{
    protected $table = 'post_comment';
    protected $primaryKey = 'commid';
    public $timestamps = false;
}
