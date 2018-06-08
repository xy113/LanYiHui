<?php

namespace App\Models;

/**
 * App\Models\Feedback
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid
 * @property string $username
 * @property string $contact
 * @property string $title
 * @property string $message
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereUsername($value)
 */
class Feedback extends BaseModel
{
    protected $table = 'feedback';
    protected $primaryKey = 'id';
}
