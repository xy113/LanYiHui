<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\VideoParser;
use App\Models\PostCatlog;
use App\Models\PostContent;
use App\Models\PostImage;
use App\Models\PostItem;
use App\Models\PostLog;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class PostController extends BaseController
{
    /**
     * 文章列表
     */
    public function index(Request $request){

        $condition = $queryParams = [];
        $searchType = intval($request->input('searchType'));
        $queryParams['searchType'] = $searchType;
        $data = [
            'searchType'=>$searchType,
            'title'=>'',
            'username'=>'',
            'catid'=>'',
            'status'=>'',
            'type'=>'',
            'time_begin'=>'',
            'time_end'=>'',
            'q'=>''
        ];

        if ($searchType) {
            $title = $request->input('title');
            if ($title) {
                $condition[] = ['i.title', 'LIKE', "%$title%"];
                $queryParams['title'] = $title;
                $data['title'] = $title;
            }

            $username = $request->input('username');
            if ($username) {
                $condition[] = ['i.username', '=', $username];
                $queryParams['username'] = $username;
            }
            $data['username'] = $username;

            $catid = $request->input('catid');
            if ($catid) {
                $condition[] = ['i.catid', '=', $catid];
                $queryParams['catid'] = $catid;
            }
            $data['catid'] = $catid;

            $status = $request->input('status');
            if ($status != '') {
                $condition[] = ['i.status', '=', $status];
                $queryParams['status'] = $status;
            }
            $data['status'] = $status;

            $type = $request->input('type');
            if ($type) {
                $condition[] = ['i.type', '=', $type];
                $queryParams['type'] = $type;
            }
            $data['type'] = $type;

            $time_begin = $request->input('time_begin');
            if ($time_begin) {
                $condition[] = ['i.create_at', '>', strtotime($time_begin)];
                $queryParams['time_begin'] = $time_begin;
            }
            $data['time_begin'] = $time_begin;

            $time_end = $request->input('time_end');
            if ($time_end) {
                $condition[] = ['i.create_at', '<', strtotime($time_end)];
                $queryParams['time_end'] = $time_end;
            }
            $data['time_end'] = $time_end;
        }else {
            $q = $request->input('q');
            $data['q'] = $q;
            if ($q) {
                $condition[] = ['i.title', 'LIKE', "%$q%"];
                $queryParams['q'] = $q;
            }
        }


        $data['post_types'] = trans('post.post_types');
        $data['post_status'] = trans('post.post_status');
        $data['catloglist'] = PostCatlog::getTree();

        $data['itemlist'] = [];
        $db = DB::table('post_item as i')->leftJoin('post_catlog as c', 'c.catid', '=', 'i.catid')->where($condition);
        $itemlist = $db->select('i.*', 'c.name as cat_name')->orderBy('i.aid','DESC')->paginate(20);
        foreach ($itemlist as $item){
            $data['itemlist'][$item->aid] = get_object_vars($item);
        }
        $data['pagination'] = $itemlist->appends($queryParams)->links();
        return view('admin.post.list', $data);
    }

    /**
     * 删除文章
     */
    public function delete(Request $request){
        $items = $request->input('items');
        if ($items && is_array($items)){
            foreach ($items as $aid){
                PostItem::deleteAll($aid);
            }
        }
        return ajaxReturn();
    }

    /**
     * 移动文章
     */
    public function move(){
        if ($this->checkFormSubmit()){
            $items = $_GET['items'];
            $target = intval($_GET['target']);
            if ($items && is_array($items)){
                foreach ($items as $aid){
                    PostItem::getInstance()->where(array('aid'=>$aid))->data(array('catid'=>$target))->save();
                }
            }
        }
        $this->showAjaxReturn();
    }

    /**
     * 审核文章
     */
    public function review(){
        $event = $this->request->input('event');
        $status = $event === 'pass' ? 1 : 0;

        $items = $this->request->post('items');
        if ($items) {
            foreach ($items as $aid){
                PostItem::where('aid', $aid)->update(['status'=>$status]);
            }
        }

        return ajaxReturn();
    }

    /**
     * 设置文章图片
     */
    public function setimage(Request $request){
        $aid = $request->input('aid');
        $image = $request->input('image');
        if ($aid && $image){
            PostItem::where('aid', $aid)->update(['image'=>$image]);
            return ajaxReturn(['aid'=>$aid,'image'=>$image]);
        }else {
            return ajaxError(1, 'invalid parameter');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function publish(Request $request){

        $data = [
            'aid'=>0,
            'catid'=>0,
            'type'=>'article',
            'item'=>[
                'aid'=>0,
                'type'=>'article',
                'catid'=>0,
                'created_at'=>date('Y-m-d H:i:s'),
                'title'=>'',
                'from'=>setting('sitename'),
                'fromurl'=>setting('siteurl'),
                'image'=>'',
                'alias'=>'',
                'allowcomment'=>'',
                'tags'=>'',
                'author'=>$this->username,
                'price'=>0,
                'summary'=>''
            ],
            'content'=>[
                'aid'=>0,
                'content'=>'',
                'created_at'=>time(),
                'updated_at'=>time()
            ],
            'gallery'=>[],
            'media'=>[]
        ];

        $aid = intval($request->get('aid'));
        $data['aid'] = $aid;
        if ($aid) {
            $item = PostItem::where('aid', $aid)->first()->toArray();
            $item['created_at'] = $item['created_at'] ? @date('Y-m-d H:i:s', $item['created_at']) : @date('Y-m-d H:i:s');
            $data['type'] = in_array($item['type'], array('image','video')) ? $item['type'] : 'article';
            $data['catid'] = $item['catid'];
            $data['item'] = array_merge($data['item'], $item);

            $content = PostContent::where('aid',$aid)->first();
            if ($content) {
                $data['content'] = $content->toArray();
            }
            //相册列表
            $gallery = PostImage::where('aid', $aid)->orderBy('displayorder', 'ASC')->orderBy('id', 'ASC')->get();
            if ($gallery) {
                foreach ($gallery as $image){
                    $data['gallery'][] = $image->toArray();
                }
            }
            //获取媒体信息
            $media = PostMedia::where('aid', $aid)->first();
            if ($media) {
                $data['media'] = $media->toArray();
            }
        }else {
            $catid = $request->input('catid');
            $data['catid'] = $catid ? $catid : 0;

            $type = $request->input('type');
            $type = in_array($type, array('image','video', 'voice')) ? $type : 'article';
            $data['type'] = $type;
            $data['item']['type'] = $type;
        }
        $data['catloglist'] = PostCatlog::getTree();
        return view('admin.post.publish', $data);
    }

    /**
     * 保存文章
     */
    public function save(Request $request){
        $newpost = $request->input('newpost');
        $content = $request->input('content');
        $aid = intval($request->input('aid'));
        if (is_array ($newpost)) {
            $newpost = rejectNullValues($newpost);
            if (!$newpost['title']) {
                return $this->showError(trans('post.post title empty'));
            }

            if (!$newpost['from']) {
                $newpost['from'] = setting('sitename');
            }

            if (!$newpost['fromurl']) {
                $newpost['fromurl'] = setting('fromurl');
            }

            $summary = $newpost['summary'];
            if (!$summary) {
                $summary = mb_substr(stripHtml($content), 120);
            }
            $summary = str_replace('&amp;', '&', $summary);
            $summary = str_replace('&nbsp;', '', $summary);
            $summary = str_replace('　', '', $summary);
            $summary = preg_replace('/\s/', '', $summary);
            $newpost['summary'] = $summary;

            //发布时间设置
            $newpost['created_at'] = $newpost['created_at'] ? strtotime($newpost['created_at']) : time();

            $eventType = $aid ? 'edit' : 'add';
            if ($eventType == 'edit') {
                //修改文章
                $newpost['updated_at'] = time();
                PostItem::where('aid',$aid)->update($newpost);
                //记录日志
                PostLog::insert([
                    'aid'=>$aid,
                    'title'=>$newpost['title'],
                    'uid'=>$this->uid,
                    'username'=>$this->username,
                    'action_type'=>'update',
                    'created_at'=>time(),
                    'updated_at'=>time()
                ]);
            }else {
                //添加新文章
                $newpost['uid'] = $this->uid;
                $newpost['username'] = $this->username;
                $aid = PostItem::insertGetId($newpost);

                //记录日志
                PostLog::insert([
                    'aid'=>$aid,
                    'title'=>$newpost['title'],
                    'uid'=>$this->uid,
                    'username'=>$this->username,
                    'action_type'=>'insert',
                    'created_at'=>time(),
                    'updated_at'=>time()
                ]);
            }

            //保存文章内容
            if (PostContent::where('aid', $aid)->count()){
                PostContent::where('aid', $aid)->update([
                   'content'=>$content,
                    'updated_at'=>time()
                ]);
            }else {
                PostContent::insert([
                    'aid'=>$aid,
                    'content'=>$content,
                    'created_at'=>time()
                ]);
            }

            //添加相册
            $gallery = $request->input('gallery');
            if ($gallery) {
                $imageList = array();
                if ($eventType == 'edit') {
                    foreach (PostImage::where('aid',$aid)->orderBy('displayorder','ASC')->get() as $img){
                        $imageList[$img['id']]['mark'] = 'delete';
                        $imageList[$img['id']]['img'] = $img;
                    }
                }

                $displayorder = 0;
                foreach ($gallery as $id=>$img){
                    $imageList[$id]['img'] = $img;
                    $imageList[$id]['img']['displayorder'] = $displayorder++;
                    if (isset($imageList[$id])) {
                        $imageList[$id]['mark'] = 'update';
                    }else {
                        $imageList[$id]['mark'] = 'insert';
                    }
                }

                foreach ($imageList as $id=>$img){
                    if ($img['mark'] == 'insert'){
                        $img['img']['aid'] = $aid;
                        $img['img']['uid'] = $this->uid;
                        PostImage::insert($img['img']);
                    }elseif ($img['mark'] == 'update'){
                        PostImage::where('id',$id)->update($img['img']);
                    }else {
                        PostImage::where(array('id'=>$id))->delete();
                    }
                }
                //将第一张设为文章图片
                if (!$newpost['image']) {
                    $image = reset($gallery);
                    PostItem::where('aid',$aid)->update(['image'=>$image['image']]);
                }
            }

            $media = $request->input('media');
            if ($media && $media['original_url']){
                if ($source = VideoParser::parse($media['original_url'])) {
                    $media['aid'] = $aid;
                    $media['media_source'] = $source->swf;
                    $media['media_thumb'] = $source->img;
                    $media['media_link'] = $source->url;

                    if (PostMedia::where('aid', $aid)->exists()){
                        PostMedia::where('aid', $aid)->update($media);
                    }else {
                        PostMedia::insert($media);
                    }
                }
            }

            if ($eventType == 'edit'){
                $links = array (
                    array (
                        'text' => trans('common.reedit'),
                        'url' => URL::action('Admin\PostController@publish', ['aid'=>$aid])
                    ),
                    array (
                        'text'=>trans('common.view'),
                        'url'=>post_url($aid),
                        'target'=>'_blank'
                    ),
                    array(
                        'text'=>trans('common.back_list'),
                        'url'=>url('/admin/post/index')
                    )
                );
                return $this->showSuccess(trans('post.post update success'), null, $links, null,false);
            }else {
                $links = array (
                    array (
                        'text' => trans('common.continue_publish'),
                        'url' => URL::action('Admin\PostController@publish', ['type'=>$newpost['type'],'catid'=>$newpost['catid']])
                    ),
                    array (
                        'text'=>trans('common.view'),
                        'url'=>post_url($aid),
                        'target'=>'_blank'
                    ),
                    array(
                        'text'=>trans('common.back_list'),
                        'url'=>url('/admin/post/index')
                    )
                );
                return $this->showSuccess(trans('post.post save success'), null, $links, null,true);
            }

        } else {
            return $this->showError(trans('common.invalid parameter'));
        }
    }
}
