<?php

namespace App\Models;

/**
 * App\Models\RecruitItem
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $catid
 * @property int $uid
 * @property string $username
 * @property string $title
 * @property int $num 招募人数
 * @property string $content
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 * @property int $views
 * @property int $enrolment 报名人数
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitItem whereCatid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitItem whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitItem whereEnrolment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitItem whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitItem whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitItem whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitItem whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RecruitItem whereViews($value)
 */
class RecruitItem extends BaseModel
{
    protected $table = 'recruit_item';
    protected $primaryKey = 'id';
}
