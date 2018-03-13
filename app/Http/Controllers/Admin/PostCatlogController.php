<?php

namespace App\Http\Controllers\Admin;

use App\Models\PostCatlog;
use App\Models\PostItem;
use Illuminate\Http\Request;

class PostCatlogController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(){
        $data = [];
        $data['catloglist'] = PostCatlog::getTree();
        return view('admin.post.catlog_list', $data);
    }

    /**
     * 编辑分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function edit(Request $request){
        if ($request->post('formsubmit') === 'yes'){
            $catid = intval($request->post('catid'));
            $catlog = $request->post('catlog');
            if ($catid) {
                PostCatlog::where('catid', $catid)->update($catlog);
            }else {
                PostCatlog::insert($catlog);
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {
            $catid = $request->get('catid');
            $data = [
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
            ];

            if ($catid) {
                $catlog = PostCatlog::where('catid', $catid)->first();
                if ($catlog) $data['catlog'] = $catlog->toArray();
            }

            $data['catloglist'] = PostCatlog::getTree();

            return view('admin.post.catlog_edit', $data);
        }
    }

    /**
     * 删除分类
     * @throws \Exception
     */
    public function delete(Request $request){
        $catid = intval($request->input('catid'));
        if ($this->isOnSubmit()) {
            $moveto = $request->post('moveto');
            $deleteChilds = $request->post('deleteChilds');

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
            $data = [
                'catid'=>$catid,
                'catlog'=>[],
                'catloglist'=>[]
            ];
            $catlog = PostCatlog::where('catid', $catid)->first();
            if ($catlog) $data['catlog'] = $catlog->toArray();
            $data['catloglist'] = PostCatlog::getTree(false);

            return view('admin.post.catlog_delete', $data);
        }
    }

    /**
     * 合并分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function merge(Request $request){
        if ($this->isOnSubmit()) {
            $target = intval($request->post('target'));
            $source = $request->post('source');
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
            return view('admin.post.catlog_merge', ['catloglist'=>PostCatlog::getTree(false)]);
        }
    }

    /**
     *
     */
    public function seticon(Request $request){
        $catid = intval($request->post('catid'));
        $icon = $request->post('icon');
        if ($catid && $icon){
            PostCatlog::where('catid', $catid)->update(['icon'=>$icon]);
        }
        return ajaxReturn();
    }
}
