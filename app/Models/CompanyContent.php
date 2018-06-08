<?php

namespace App\Models;

/**
 * App\Models\CompanyContent
 *
 * @mixin \Eloquent
 * @property int $company_id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompanyContent whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompanyContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompanyContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompanyContent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompanyContent whereUpdatedAt($value)
 */
class CompanyContent extends BaseModel
{
    protected $table = 'company_content';
    protected $primaryKey = 'company_id';
}
