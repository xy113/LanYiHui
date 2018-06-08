<?php

namespace App\Models;

/**
 * App\Models\RecruitRecord
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $recruit_id
 * @property int $uid
 * @property string $username
 * @property int $resume_id
 * @property string $fullname
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitRecord whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitRecord whereRecruitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitRecord whereResumeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitRecord whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitRecord whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitRecord whereUsername($value)
 */
class RecruitRecord extends BaseModel
{
    protected $table = 'recruit_record';
    protected $primaryKey = 'id';
}
