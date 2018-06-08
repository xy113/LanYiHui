<?php

namespace App\Http\Controllers\Minapp;

use App\Models\PostContent;
use App\Models\PostItem;

class PostController extends BaseController
{

    public function get_item()
    {
        $aid = $this->request->input('aid');
        $item = PostItem::where('aid', $aid)->first();
        $content = PostContent::where('aid', $aid)->first();

        return ajaxReturn([
            'item'=>$item,
            'content'=>$content
        ]);
    }

    public function batchget_item()
    {
        $offset = intval($this->request->input('offset'));
        $count = intval($this->request->input('count'));
        !$count && $count = 20;

        $condition = ['status'=>1];
        $catid = intval($this->request->input('catid'));
        if ($catid) $condition['catid'] = $catid;

        $items = PostItem::where($condition)->offset($offset)->limit($count)->orderByDesc('aid')
            ->get()->map(function ($item) {
                $item->image = image_url($item->image);
                return $item;
            });

        return ajaxReturn([
            'items'=>$items,
            'uid'=>$this->uid,
            'username'=>$this->username
        ]);
    }
}
