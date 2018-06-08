<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-25
 * Time: 14:53
 */

namespace App\Models;

/**
 * App\Models\MemberWork
 *
 * @property-read \App\Models\MemberArchive $archive
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid
 * @property string $company
 * @property string $status
 * @property string $job
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string $experience
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberWork whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberWork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberWork whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberWork whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberWork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberWork whereJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberWork whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberWork whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberWork whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberWork whereUpdatedAt($value)
 */
class MemberWork extends BaseModel
{
    protected $table = 'member_work';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function archive(){
        return $this->belongsTo('App\Models\MemberArchive','uid','uid');
    }
}