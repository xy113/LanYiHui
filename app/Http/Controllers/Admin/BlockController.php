<?php

namespace App\Http\Controllers\Admin;

use App\Models\Block;
use App\Models\BlockItem;

class BlockController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index() {
        if ($this->isOnSubmit()) {
            $blocks = $this->request->post('blocks');
            foreach ($blocks as $block_id) {
                Block::where('block_id', $block_id)->delete();
                BlockItem::where('block_id', $block_id)->delete();
            }
            return ajaxReturn();
        }else {

            $blocklist = Block::paginate(20);
            $this->data['pagination'] = $blocklist->links();

            $this->data['itemlist'] = [];
            $blocklist->map(function ($block){
                $this->data['itemlist'][$block->block_id] = $block;
            });

            return view('admin.block.blocks', $this->data);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(){
        $block_id = $this->request->input('block_id');
        if ($this->isOnSubmit()) {
            $block = $this->request->post('block');
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemlist() {
        $block_id = $this->request->input('block_id');

        if ($this->isOnSubmit()) {
            $delete = $this->request->post('delete');
            if ($delete) {
                foreach ($delete as $id) {
                    BlockItem::where('id', $id)->delete();
                }
            }

            $itemlist = $this->request->post('itemlist');
            if ($itemlist) {
                foreach ($itemlist as $id=>$item) {
                    BlockItem::where('id', $id)->update($item);
                }
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {

            $this->data['block_id'] = $block_id;
            $itemlist = BlockItem::where('block_id', $block_id)->paginate(20);
            $this->data['pagination'] = $itemlist->links();

            $this->data['itemlist'] = [];
            $itemlist->map(function ($item){
                $this->data['itemlist'][$item->id] = $item;
            });

            return view('admin.block.items', $this->data);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit_item(){
        $id = $this->request->input('id');
        $block_id = $this->request->input('block_id');
        if ($this->isOnSubmit()) {
            $item = $this->request->post('item');
            if ($id) {
                BlockItem::where('id', $id)->update($item);
            }else {
                $item['block_id'] = $block_id;
                BlockItem::insert($item);
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {

            $this->appends([
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
            ]);

            if ($id) {
                $item = BlockItem::where('id', $id)->first();
                if ($item) {
                    $this->data['block_id'] = $item->block_id;
                    $this->data['item'] = $item;
                }
            }

            return view('admin.block.edit_item', $this->data);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function setimage(){
        $id = $this->request->input('id');
        $image = $this->request->input('image');
        if ($id && $image) {
            BlockItem::where('id', $id)->update(['image'=>$image]);
        }
        return ajaxReturn();
    }
}
