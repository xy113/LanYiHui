<?php

namespace App\Models;

/**
 * App\Models\MemberInfo
 *
 * @mixin \Eloquent
 * @property int $uid
 * @property string|null $name
 * @property int $sex
 * @property string $birthday
 * @property int $blood
 * @property int $star
 * @property string $qq
 * @property string $weixin
 * @property string|null $country
 * @property string|null $province
 * @property string|null $city
 * @property string|null $district
 * @property string|null $town
 * @property string|null $street
 * @property string|null $introduction
 * @property string|null $tags
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $locked
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereBlood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereQq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereTown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberInfo whereWeixin($value)
 */
class MemberInfo extends BaseModel
{
    protected $table = 'member_info';
    protected $primaryKey = 'uid';
    public $timestamps = false;
}
