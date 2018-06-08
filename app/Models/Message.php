<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-17
 * Time: 11:04
 */
namespace App\Models;

/**
 * App\Models\Message
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $children
 * @property-read \App\Models\Member $owner
 * @property-read \App\Models\Message $parent
 * @property-read \App\Models\Message $reply
 * @property-read \App\Models\School $school
 * @property-read \App\Models\Member $visitor
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid
 * @property int $vid
 * @property int $parent_id
 * @property int $reply_id
 * @property string $content
 * @property int $school_id
 * @property string|null $level
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereReplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereVid($value)
 */
class Message extends BaseModel
{
    protected $table = 'message';
    protected $primaryKey = 'id';
    public function school(){
        return $this->hasOne('App\Models\School');
    }
    public function owner(){
        return $this->hasOne('App\Models\Member','uid','uid');
    }
    public function visitor(){
        return $this->hasOne('App\Models\Member','uid','vid');
    }
    public function parent(){
        return $this->hasOne('App\Models\Message','id','parent_id');
    }
    public function reply(){
        return $this->hasOne('App\Models\Message','id','reply_id');
    }
    public function children(){
        return $this->hasMany('App\Models\Message','parent_id','id');
    }
}