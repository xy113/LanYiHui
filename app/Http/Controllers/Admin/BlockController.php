<?php

namespace App\Http\Controllers\Admin;

use App\Models\Block;
use App\Models\BlockItem;
use Illuminate\Http\Request;

class BlockController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request) {
        if ($this->isOnSubmit()) {
            $blocks = $request->post('blocks');
            foreach ($blocks as $block_id) {
                Block::where('block_id', $block_id)->delete();
                BlockItem::where('block_id', $block_id)->delete();
            }
            return ajaxReturn();
        }else {
            $data = [
                'itemlist'=>[],
                'pagination'=>''
            ];

            $blocklist = Block::paginate(20);
            $data['pagination'] = $blocklist->links();

            if ($blocklist) {
                foreach ($blocklist as $block){
                    $data['itemlist'][$block->block_id] = $block->toArray();
                }
            }

            return view('admin.block.blocks', $data);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request){
        $block_id = intval($request->input('block_id'));
        if ($this->isOnSubmit()) {
            $block = $request->post('block');
            if ($block['block_name']) {
                if (is_null($block['block_desc'])) $block['block_desc'] = '';
                if ($block_id) {
                    Block::where('block_id', $block_id)->update($block);
                }else {
                    Block::insert($block);
                }
            }
            return ajaxReturn();
        }else {
            $block = Block::where('block_id', $block_id)->first()->toArray();
            return ajaxReturn($block);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemlist(Request $request) {
        $block_id = intval($request->input('block_id'));

        if ($this->isOnSubmit()) {
            $delete = $request->post('delete');
            if ($delete) {
                foreach ($delete as $id) {
                    BlockItem::where('id', $id)->delete();
                }
            }

            $itemlist = $request->post('itemlist');
            if ($itemlist) {
                foreach ($itemlist as $id=>$item) {
                    BlockItem::where('id', $id)->update($item);
                }
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {
            $data = [
                'block_id'=>$block_id,
                'itemlist'=>[],
                'pagination'=>''
            ];

            $itemlist = BlockItem::where('block_id', $block_id)->paginate(20);
            $data['pagination'] = $itemlist->links();

            foreach ($itemlist as $item) {
                $data['itemlist'][$item->id] = $item->toArray();
            }

            return view('admin.block.items', $data);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit_item(Request $request){
        $id = intval($request->input('id'));
        $block_id = intval($request->input('block_id'));
        if ($this->isOnSubmit()) {
            $item = $request->post('item');
            if ($id) {
                BlockItem::where('id', $id)->update($item);
            }else {
                $item['block_id'] = $block_id;
                BlockItem::insert($item);
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {
            $data = [
                'id'=>$id,
                'block_id'=>$block_id,
                'item'=>[
                    'image'=>'',
                    'title'=>'',
                    'subtitle'=>'',
                    'url'=>'',
                    'field_1'=>'',
                    'field_2'=>'',
                    'field_3'=>''
                ]
            ];

            if ($id) {
                $item = BlockItem::where('id', $id)->first();
                if ($item) {
                    $data['block_id'] = $item->block_id;
                    $data['item'] = $item->toArray();
                }
            }

            return view('admin.block.edit_item', $data);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setimage(Request $request){
        $id = $request->input('id');
        $image = $request->input('image');
        if ($id && $image) {
            BlockItem::where('id', $id)->update(['image'=>$image]);
        }
        return ajaxReturn();
    }
}
