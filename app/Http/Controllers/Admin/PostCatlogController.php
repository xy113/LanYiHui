<?php

namespace App\Http\Controllers\Admin;

use App\Models\PostCatlog;
use App\Models\PostItem;

class PostCatlogController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(){

        $this->data['catloglist'] = PostCatlog::getTree();
        return view('admin.post.catlog_list', $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function edit(){
        if ($this->isOnSubmit()){
            $catid = $this->request->post('catid');
            $catlog = $this->request->post('catlog');
            if ($catid) {
                PostCatlog::where('catid', $catid)->update($catlog);
            }else {
                PostCatlog::insert($catlog);
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {
            $catid = $this->request->get('catid');
            $this->appends([
                'catid'=>$catid,
                'catlog'=>[
                    'name'=>'',
                    'fid'=>0,
                    'available'=>1,
                    'template_index'=>'',
                    'template_list'=>'',
                    'template_detail'=>'',
                    'keywords'=>'',
                    'description'=>''
                ],
                'catloglist'=>[]
            ]);

            if ($catid) {
                $this->data['catlog'] = PostCatlog::where('catid', $catid)->first();
            }

            $this->data['catloglist'] = PostCatlog::getTree();

            return view('admin.post.catlog_edit', $this->data);
        }
    }

    /**
     * 删除分类
     * @throws \Exception
     */
    public function delete(){
        $catid = $this->request->input('catid');
        if ($this->isOnSubmit()) {
            $moveto = $this->request->post('moveto');
            $deleteChilds = $this->request->post('deleteChilds');

            if ($moveto || $deleteChilds) {
                $childIds = PostCatlog::getAllChildIds($catid);
                if (PostCatlog::where('catid', $catid)->delete()){
                    if ($deleteChilds) {
                        foreach ($childIds as $catid){
                            PostCatlog::where('catid', $catid)->delete();
                        }

                        foreach (PostItem::whereIn('catid', $childIds)->get(['aid']) as $item){
                            PostItem::deleteAll($item->aid);
                        }
                    }else {
                        foreach (PostCatlog::where('fid', $catid)->get() as $catlog){
                            PostCatlog::where('catid', $catlog->catid)->update(['fid'=>$moveto]);
                        }
                        PostItem::where('catid', $catid)->update(['catid'=>$moveto]);
                    }
                    PostCatlog::updateCache();
                }
            }

            return $this->showSuccess(trans('ui.update_succeed'));
        }else {

            $this->appends([
                'catid'=>$catid,
                'catlog'=>PostCatlog::where('catid', $catid)->first(),
                'catloglist'=>PostCatlog::getTree(false)
            ]);

            return view('admin.post.catlog_delete', $this->data);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function merge(){
        if ($this->isOnSubmit()) {
            $target = $this->request->post('target');
            $source = $this->request->post('source');
            if ($source) {
                foreach ($source as $catid) {
                    PostItem::where('catid', $catid)->update(['catid'=>$target]);
                    PostCatlog::where('catid', $catid)->delete();
                }
                PostCatlog::updateCache();
            }
            return $this->showSuccess(trans('ui.update_succeed'), '', [
                array('text'=>trans('common.back_list'), 'url'=>url('/admin/postcatlog'))
            ]);
        }else {

            $this->data['catloglist'] = PostCatlog::getTree(false);
            return view('admin.post.catlog_merge', $this->data);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function seticon(){
        $catid = $this->request->post('catid');
        $icon = $this->request->post('icon');
        if ($catid && $icon){
            PostCatlog::where('catid', $catid)->update(['icon'=>$icon]);
        }
        return ajaxReturn();
    }
}
