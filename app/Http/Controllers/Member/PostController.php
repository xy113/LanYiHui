<?php

namespace App\Http\Controllers\Member;

use App\Helpers\VideoParser;
use App\Models\PostCatlog;
use App\Models\PostContent;
use App\Models\PostImage;
use App\Models\PostItem;
use App\Models\PostLog;
use App\Models\PostMedia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class PostController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        if ($this->isOnSubmit()) {

        }else {

            $this->assign(['itemlist'=>[]]);
            $items = DB::table('post_item as i')
                ->leftJoin('post_catlog as c', 'c.catid', '=', 'i.catid')
                ->where([])
                ->select('i.*', 'c.name as cat_name')
                ->orderBy('i.aid','DESC')
                ->paginate(10);
            $this->data['pagination'] = $items->appends([])->links();
            $items->map(function ($item){
                $this->data['itemlist'][$item->aid] = get_object_vars($item);
            });

            $this->assign(['menu'=>'post']);

            return $this->view('member.post.index');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function publish(){

        if ($this->isOnSubmit()) {
            $aid = $this->request->get('aid');
            $newpost = $this->request->post('newpost');
            $content = $this->request->post('content');

            if (is_array ($newpost)) {

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
                    PostItem::where(['uid'=>$this->uid, 'aid'=>$aid])->update($newpost);
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
                if (PostContent::where(['uid'=>$this->uid, 'aid'=>$aid])->exists()){
                    PostContent::where(['uid'=>$this->uid, 'aid'=>$aid])->update([
                        'content'=>$content,
                        'updated_at'=>time()
                    ]);
                }else {
                    PostContent::insert([
                        'aid'=>$aid,
                        'uid'=>$this->uid,
                        'content'=>$content,
                        'created_at'=>time()
                    ]);
                }

                //添加相册
                $gallery = $this->request->post('gallery');
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
                        PostItem::where(['uid'=>$this->uid, 'aid'=>$aid])->update(['image'=>$image['image']]);
                    }
                }

                $media = $this->request->post('media');
                if ($media && $media['original_url']){
                    if ($source = VideoParser::parse($media['original_url'])) {
                        $media['aid'] = $aid;
                        $media['uid'] = $this->uid;
                        $media['media_source'] = $source->swf;
                        $media['media_thumb'] = $source->img;
                        $media['media_link'] = $source->url;

                        if (PostMedia::where(['uid'=>$this->uid, 'aid'=>$aid])->exists()){
                            PostMedia::where(['uid'=>$this->uid, 'aid'=>$aid])->update($media);
                        }else {
                            PostMedia::insert($media);
                        }
                    }
                }

                if ($eventType == 'edit'){
                    $links = array (
                        array (
                            'text' => trans('common.reedit'),
                            'url' => URL::action('Member\PostController@publish', ['aid'=>$aid])
                        ),
                        array (
                            'text'=>trans('common.view'),
                            'url'=>post_url($aid),
                            'target'=>'_blank'
                        ),
                        array(
                            'text'=>trans('common.back_list'),
                            'url'=>url('/member/post')
                        )
                    );
                    return $this->showSuccess(trans('post.post update success'), null, $links, null,false);
                }else {
                    $links = array (
                        array (
                            'text' => trans('common.continue_publish'),
                            'url' => URL::action('Member\PostController@publish', ['type'=>$newpost['type'],'catid'=>$newpost['catid']])
                        ),
                        array (
                            'text'=>trans('common.view'),
                            'url'=>post_url($aid),
                            'target'=>'_blank'
                        ),
                        array(
                            'text'=>trans('common.back_list'),
                            'url'=>url('/member/post')
                        )
                    );
                    return $this->showSuccess(trans('post.post save success'), null, $links, null,true);
                }

            } else {
                return $this->showError(trans('common.invalid parameter'));
            }
        }else {
            $aid = $this->request->get('aid');
            $catid = $this->request->get('catid');
            $type  = $this->request->input('type');
            $type  = in_array($type, array('image','video', 'voice')) ? $type : 'article';
            $this->assign([
                'aid'=>$aid,
                'catid'=>$catid,
                'type'=>$type,
                'item'=>[
                    'aid'=>0,
                    'type'=>$type,
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
                'media'=>[],
                'menu'=>'post'
            ]);

            if ($aid) {
                $item = PostItem::where(['aid' => $aid, 'uid' => $this->uid])->first()->toArray();
                $item['created_at'] = $item['created_at'] ? @date('Y-m-d H:i:s', $item['created_at']) : @date('Y-m-d H:i:s');
                $item['type'] = in_array($item['type'], array('image','video')) ? $item['type'] : 'article';
                $this->assign([
                    'type'=>$item['type'],
                    'catid'=>$item['catid'],
                    'item'=>$item
                ]);

                $this->data['content'] = PostContent::where(['aid' => $aid])->first();

                //相册列表
                $this->data['gallery'] = PostImage::where(['aid' => $aid])->orderBy('displayorder', 'ASC')->orderBy('id', 'ASC')->get();

                //获取媒体信息
                $this->data['media'] = PostMedia::where(['aid' => $aid])->first();

            }
            $this->data['catloglist'] = PostCatlog::getTree();
            return $this->view('member.post.publish');
        }
    }
}
