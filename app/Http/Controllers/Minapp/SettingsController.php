<?php

namespace App\Http\Controllers\Minapp;

use App\Models\Settings;

class SettingsController extends BaseController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get()
    {
        $name = $this->request->input('name');
        if ($name) {
            $setting = Settings::where('skey', $name)->first();
            return ajaxReturn([$setting->skey=>$setting->svalue]);
        } else {
            $settings = [];
            Settings::all()->map(function ($setting) use (&$settings) {
                $settings[$setting->skey] = $setting->svalue;
            });

            return ajaxReturn(['settings'=>$settings]);
        }
    }
}
