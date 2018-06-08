<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

/**
 * App\Models\Settings
 *
 * @mixin \Eloquent
 * @property string $skey 标识
 * @property string|null $svalue 值
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereSkey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereSvalue($value)
 */
class Settings extends BaseModel
{
    protected $table = 'settings';
    //protected $primaryKey = 'skey';

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function updateCache(){
        $settings = [];
        Settings::all()->map(function ($set) use (&$settings){
            if (is_null($set->skey)) return;
            if (is_null($set->svalue)) {
                $settings[$set->skey] = '';
            }else {
                $settings[$set->skey] = $set->svalue;
            }
        });
        Cache::forever('_settings', $settings);
    }

    /**
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function getCache(){
        $settings = Cache::get('_settings');
        if (is_array($settings)) {
            return $settings;
        }else {
            Settings::updateCache();
            return Settings::getCache();
        }
    }
}
