<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BaseModel
 *
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    protected $dateFormat = 'U';
    public $timestamps = false;
    /**
     * @return \Illuminate\Support\Carbon|int
     */
    public function freshTimestamp()
    {
        return time();
    }

    public function fromDateTime($value)
    {
        return $value;
    }

    /**
     * @return string
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }
}
