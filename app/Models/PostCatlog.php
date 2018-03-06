<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

class PostCatlog extends BaseModel
{
    protected $table = 'post_catlog';
    protected $primaryKey = 'catid';
    public $timestamps = false;

    /**
     *
     */
    public static function updateCache(){
        $catloglist = array();
        foreach (PostCatlog::where('available', 1)->orderBy('displayorder', 'ASC')->orderBy('catid', 'ASC')->get() as $catlog){
            $catloglist[$catlog->catid] = $catlog->toArray();
        }
        Cache::forever('post_catlog', $catloglist);
    }

    /**
     * @return bool|mixed
     * @throws \Exception
     */
    public static function getCache(){
        $catloglist = Cache::get('post_catlog');
        if (!is_array($catloglist)) {
            PostCatlog::updateCache();
            return PostCatlog::getCache();
        }else {
            return $catloglist;
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function getTree($useCache = true){
        $catloglist = [];
        if ($useCache) {
            foreach (PostCatlog::getCache() as $catid=>$catlog){
                $catloglist[$catlog['fid']][$catid] = $catlog;
            }
        }else {
            foreach (PostCatlog::all() as $catlog){
                $catloglist[$catlog->fid][$catlog->catid] = $catlog->toArray();
            }
        }

        return $catloglist;
    }

    /**
     * @param $catid
     * @param array $childCatids
     * @return array
     * @throws \Exception
     */
    public static function getAllChildIds($catid, &$childCatids=array()){
        static $catloglist;
        if (!$childCatids) $childCatids = array($catid);
        if (!$catloglist) $catloglist = PostCatlog::getCache();
        foreach ($catloglist as $catlog){
            if ($catlog['fid'] == $catid){
                $childCatids[] = $catlog['catid'];
                PostCatlog::getAllChildIds($catlog['catid'], $childCatids);
            }
        }
        return $childCatids;
    }

    /**
     * @param $catid
     * @param array $childCatlog
     * @return array
     * @throws \Exception
     */
    public static function getAllChilds($catid, &$childCatlog=array()){
        static $catloglist;
        if (!$catloglist) $catloglist = PostCatlog::getCache();
        if (!$childCatlog) $childCatlog[] = $catloglist[$catid];
        foreach ($catloglist as $catlog){
            if ($catlog['fid'] == $catid){
                $childCatlog[] = $catlog;
                PostCatlog::getAllChilds($catlog['catid'], $childCatlog);
            }
        }
        return $childCatlog;
    }

    /**
     * @param $catid
     * @param array $parentCatids
     * @return mixed
     * @throws \Exception
     */
    public static function getParentIds($catid, &$parentCatids=array()){
        static $catloglist;
        if (!$catloglist) $catloglist = PostCatlog::getCache();
        if (!$parentCatids) $parentCatids = array($catid);

        $curCatlog = $catloglist[$catid];
        if ($curCatlog['fid']) {
            foreach ($catloglist as $catlog){
                if ($catlog['catid'] == $curCatlog['fid']){
                    $parentCatids[] = $catlog['catid'];
                    PostCatlog::getParentIds($catlog['catid'], $parentCatids);
                }
            }
        }
        return $parentCatids;
    }

    /**
     * @param $catid
     * @param array $parents
     * @return array
     * @throws \Exception
     */
    public static function getParents($catid, &$parents=array()){
        static $catloglist;
        if (!$catloglist) $catloglist = PostCatlog::getCache();

        $curCatlog = $catloglist[$catid];
        if (!$parents) $parents = array($curCatlog);
        if ($curCatlog['fid']) {
            foreach ($catloglist as $catlog){
                if ($catlog['catid'] == $curCatlog['fid']){
                    $parents[] = $catlog['catid'];
                    PostCatlog::getParents($catlog['catid'], $parents);
                }
            }
        }
        return $parents;
    }
}
