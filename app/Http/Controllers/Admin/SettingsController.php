<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends BaseController
{
    public function index($type){
        $settings = array();
        foreach (Settings::all() as $setting){
            $settings[$setting->skey] = $setting->svalue;
        }
        return view('admin.settings.'.$type, ['settings'=>$settings]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function save(Request $request){
        $settings = array();
        foreach (Settings::all() as $setting){
            $settings[$setting->skey] = $setting->svalue;
        }

        foreach (rejectNullValues($request->input('settings')) as $skey=>$svalue){
            if (array_key_exists($skey, $settings)) {
                Settings::where('skey', $skey)->update(['svalue'=>$svalue]);
            }else {
                Settings::insert(['skey'=>$skey, 'svalue'=>$svalue]);
            }
        }
        try{
            Settings::updateCache();
            return $this->showSuccess(trans('ui.save_succeed'));
        }catch (\InvalidArgumentException $exception){
            return $exception->getMessage();
        }
    }
}
