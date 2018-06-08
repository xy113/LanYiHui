<?php

namespace App\Models;

/**
 * App\Models\Company
 *
 * @mixin \Eloquent
 * @property int $company_id 企业ID
 * @property string $company_name 企业名称
 * @property string $company_logo 企业LOGO
 * @property string $company_image 门头照片
 * @property string $company_license_no 营业执照号码
 * @property string $company_license_pic 营业执照的照片
 * @property string $province 省份
 * @property string $city 城市
 * @property string $district 区县
 * @property string $street 街道地址
 * @property string $contact 联系人
 * @property string $tel 联系电话
 * @property string $deleted_at
 * @property string $created_at 建档时间
 * @property string $updated_at 修改时间
 * @property float $lng
 * @property float $lat
 * @property int $view_num 浏览数
 * @property string $username
 * @property string $password
 * @property string $mobile
 * @property string $email
 * @property string|null $status -1:被禁；0：未认证；1：复核中；2：已认证；3：合作企业；4：预留位
 * @property string|null $reason
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCompanyImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCompanyLicenseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCompanyLicensePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCompanyLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereViewNum($value)
 */
class Company extends BaseModel
{
    protected $table = 'company';
    protected $primaryKey = 'company_id';
}
