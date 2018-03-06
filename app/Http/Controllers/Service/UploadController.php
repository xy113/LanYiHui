<?php

namespace App\Http\Controllers\Service;

use App\Helpers\Image;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    /**
     *
     */
    public function index(){

    }

    /**
     *
     */
    public function image(Request $request){
        $file = $request->file('file');
        $data = [
            'uid'=>$this->uid,
            'username'=>$this->username,
            'type'=>'image',
            'created_at'=>time(),
            'updated_at'=>time(),
            'extension'=>$file->extension(),
            'size'=>$file->getClientSize(),
            'name'=>$file->getClientOriginalName()
        ];
        $image = $file->store('image/'.date('Y').'/'.date('m'));
        $img = Image::make(storage_public_path($image));
        $data['width'] = $img->width();
        $data['height'] = $img->height();
        $data['thumb'] = str_replace('image/', 'thumb/', $image);
        $data['path'] = $image;
        $img->thumb(320, 240)->save(storage_public_path($data['thumb']));

        $id = Material::insertGetId($data);

        return ajaxReturn([
            'id'=>$id,
            'image'=>$image,
            'thumb'=>$data['thumb'],
            'imageurl'=>storage_url($image),
            'thumburl'=>storage_url($data['thumb'])
        ]);
    }
}
