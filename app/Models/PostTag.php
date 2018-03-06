<?php

namespace App\Models;

class PostTag extends BaseModel
{
    protected $table = 'post_tag';
    protected $primaryKey = 'tag_id';
    public $timestamps = false;
}
