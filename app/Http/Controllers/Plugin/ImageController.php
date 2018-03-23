<?php

namespace App\Http\Controllers\Plugin;

use App\Models\Material;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    /**
     *
     */
    public function index(){
        $data = [];
        $imageList = Material::where('type','image')->orderBy('id', 'DESC')->paginate(20);
        $data['pagination'] = $imageList->links();
        $data['imagelist'] = [];

        foreach ($imageList as $image){
            $data['imagelist'][$image->id] = [
                'id'=>$image->id,
                'image'=>$image->path,
                'thumb'=>$image->thumb,
                'imageurl'=>storage_url($image->path),
                'thumburl'=>storage_url($image->thumb)
            ];
        }
        $this->assign($data);
        return $this->view('plugin.image');
    }
}
