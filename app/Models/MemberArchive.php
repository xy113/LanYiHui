<?php

namespace App\Models;

/**
 * App\Models\MemberArchive
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MemberEducation[] $education
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MemberExperience[] $experience
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MemberWork[] $work
 * @mixin \Eloquent
 * @property int $id 会员ID
 * @property int $uid 网站会员ID
 * @property string $username
 * @property string $fullname 姓名
 * @property string $phone
 * @property int $sex 性别
 * @property string $birthday 生日
 * @property string $headimg 头像
 * @property string $university 大学
 * @property string $enrollyear 入学年份
 * @property string $birthplace 籍贯
 * @property string $location 所在地
 * @property string $post 职务
 * @property int $status 状态
 * @property int $stars
 * @property int $views
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereBirthplace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereEnrollyear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereHeadimg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive wherePost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereStars($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereUniversity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberArchive whereViews($value)
 */
class MemberArchive extends BaseModel
{
    protected $table = 'member_archive';
    protected $primaryKey = 'id';
    public function experience(){
        return $this->hasMany('App\Models\MemberExperience','uid','uid');
    }
    public function education(){
        return $this->hasMany('App\Models\MemberEducation','uid','uid');
    }
    public function work(){
        return $this->hasMany('App\Models\MemberWork','uid','uid');
    }
}
