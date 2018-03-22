<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;

class SettingsController extends BaseController
{
    /**
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($type){

        $this->data['settings'] = [];
        Settings::all()->map(function ($setting){
            $this->data['settings'][$setting->skey] = $setting->svalue;
        });
        return view('admin.settings.'.$type, $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function save(){
        $settings = [];
        foreach (Settings::all() as $setting){
            $settings[$setting->skey] = $setting->svalue;
        }

        foreach ($this->request->post('settings') as $skey=>$svalue){
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
