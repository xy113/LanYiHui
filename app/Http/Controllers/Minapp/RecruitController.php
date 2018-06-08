<?php

namespace App\Http\Controllers\Minapp;

use App\Models\RecruitItem;

class RecruitController extends BaseController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_recruit()
    {
        $id = $this->request->input('id');
        $recruit = RecruitItem::where('id', $id)->first();
        $recruit->image = image_url($recruit->image);
        $recruit->formatted_time = @date('Y-m-d H:i');

        return ajaxReturn(['recruit'=>$recruit]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchget_recruit()
    {
        $offset = intval($this->request->input('offset'));
        $count = intval($this->request->input('count'));
        !$count && $count = 20;

        $condition = [];
        $catid = $this->request->input('catid');
        if ($catid) $condition['catid'] = $catid;

        $items = RecruitItem::where($condition)->orderByDesc('id')->offset($offset)->limit($count)
            ->get()->map(function ($item) {
                $item->image = image_url($item->image);
                return $item;
            });
        return ajaxReturn(['items'=>$items]);
    }
}
