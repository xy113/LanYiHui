<?php

namespace App\Http\Controllers\Plugin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AvatarController extends Controller
{
    /**
     *
     */
    public function index(Request $request){
        $uid  = intval($request->input('uid'));
        $size = $request->input('size');
        $size = in_array($size, array('middel','small')) ? $size : 'big';
        $avatar = $uid.'/'.$uid.'_avatar_'.$size.'.jpg';
        $avatar2 = $uid.'/'.$size.'.png';

        $dir = config('filesystems.disks.public.root').'/avatar/';
        if (is_file($dir.$avatar2)){
            $avatar = $dir.$avatar2;
        }elseif (is_file($dir.$avatar)){
            $avatar = $dir.$avatar;
        }else {
            $avatar = public_path('/images/common/avatar_default.png');
        }
        return response()->file($avatar);
    }
}
