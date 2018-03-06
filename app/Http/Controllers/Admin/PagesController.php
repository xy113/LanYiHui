<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function index(Request $request){
        if ($request->post('formsubmit') === 'yes'){
            $delete = $request->post('delete');
            if ($delete) {
                foreach ($delete as $pageid){
                    Pages::where('pageid', $pageid)->delete();
                }
            }

            $pagelist = $request->input('pagelist');
            if ($pagelist) {
                foreach ($pagelist as $pageid=>$page){
                    Pages::where('pageid', $pageid)->update($page);
                }
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {
            $catid = intval($request->get('catid'));
            $data = [
                'catid'=>$catid,
                'categorylist'=>[],
                'pagelist'=>[],
                'pagination'=>''
            ];
            $condition[] = ['type', '=', 'page'];
            if ($catid) $condition[] = ['catid', '=', $catid];

            $categorylist = Pages::where('type', 'category')->get();
            if ($categorylist) {
                foreach ($categorylist as $c){
                    $data['categorylist'][$c->pageid] = $c->toArray();
                }
            }

            $pages = Pages::where($condition)->orderBy('displayorder', 'ASC')->orderBy('pageid', 'ASC')->paginate(20);
            $data['pagination'] = $pages->appends(['catid'=>$catid])->links();
            if ($pages) {
                foreach ($pages as $p){
                    $data['pagelist'][$p->pageid] = $p->toArray();
                }
            }
            return view('admin.pages.list', $data);
        }
    }

    public function publish(Request $request){
        if ($request->post('formsubmit') === 'yes'){
            $pageid = intval($request->post('pageid'));
            $newpage = $request->input('newpage');
            return $this->save($newpage, $pageid);
        }else {
            $pageid = intval($request->get('pageid'));
            $data = [
                'catid'=>intval($request->get('catid')),
                'pageid'=>$pageid,
                'page'=>[
                    'title'=>'',
                    'alias'=>'',
                    'template'=>'',
                    'summary'=>'',
                    'body'=>''
                ],
                'categorylist'=>[]
            ];

            if ($pageid) {
                $page = Pages::where('pageid', $pageid)->first();
                if ($page) {
                    $data['catid'] = $page->catid;
                    $data['page'] = array_merge($data['page'], $page->toArray());
                }
            }
            foreach (Pages::where('type', 'category')->get() as $c){
                $data['categorylist'][$c->pageid] = $c->toArray();
            }
            return view('admin.pages.publish', $data);
        }
    }

    /**
     * @param $newpage
     * @param int $pageid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save($newpage, $pageid=0){
        $newpage['type'] = 'page';
        $newpage['updated_at'] = time();
        $newpage = rejectNullValues($newpage);
        if (!$newpage['title']) {
            return $this->showError(trans('post.post title empty'));
        }
        if ($pageid) {
            Pages::where('pageid', $pageid)->update($newpage);
        }else {
            $newpage['created_at'] = time();
            Pages::insert($newpage);
        }
        return $this->showSuccess(trans('ui.save_succeed'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Request $request){
        if ($request->post('formsubmit') === 'yes'){
            $delete = $request->post('delete');
            if ($delete) {
                foreach ($delete as $pageid){
                    Pages::where('catid', $pageid)->delete();
                    Pages::where('pageid', $pageid)->delete();
                }
            }

            $categorylist = $request->post('categorylist');
            if ($categorylist) {
                foreach ($categorylist as $pageid=>$category){
                    if ($category['title']) {
                        $category['updated_at'] = time();
                        if ($pageid > 0) {
                            Pages::where('pageid', $pageid)->update($category);
                        }else {
                            $category['type'] = 'category';
                            $category['created_at'] = time();
                            Pages::insert($category);
                        }
                    }
                }
            }
            return $this->showSuccess(trans('ui.save_succeed'));
        }else {
            $categorylist = [];
            foreach (Pages::where('type', 'category')->get() as $c){
                $categorylist[$c->pageid] = $c->toArray();
            }
            return view('admin.pages.category', ['categorylist'=>$categorylist]);
        }
    }
}
