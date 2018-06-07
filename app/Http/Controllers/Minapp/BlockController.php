<?php

namespace App\Http\Controllers\Minapp;

use App\Models\BlockItem;

class BlockController extends BaseController
{
    public function batchget_item()
    {
        $block_id = intval($this->request->input('block_id'));
        $items = BlockItem::where('block_id', $block_id)->orderBy('displayorder')->get()->map(function ($item){
            $item->thumb = image_url($item->thumb);
            $item->image = image_url($item->image);
            return $item;
        });

        return ajaxReturn(['items'=>$items]);
    }
}
