<?php

namespace App\Models;

/**
 * App\Models\PostItem
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PostComment[] $comment
 * @mixin \Eloquent
 * @property int $aid 文章ID
 * @property int $catid 分类ID
 * @property int $uid 会员ID
 * @property string $username 用户名
 * @property string $author 作者
 * @property string $type 文章形式
 * @property string $title 文章标题
 * @property string|null $alias 别名
 * @property string|null $summary 摘要
 * @property string|null $image 图片
 * @property string|null $tags 标签
 * @property string|null $created_at 发布时间
 * @property string|null $updated_at 修改时间
 * @property string $deleted_at
 * @property int $allowcomment 允许评论
 * @property int $collection_num 被收藏数
 * @property int $comment_num 评论数
 * @property int $view_num 浏览数
 * @property int $like_num 点赞数
 * @property int $status
 * @property string|null $from 来源
 * @property string|null $fromurl 来源地址
 * @property int $contents 内容数
 * @property float $price 阅读价格
 * @property int $recommend 推荐到首页
 * @property int $click1
 * @property int $click2
 * @property int $click3
 * @property int $click4
 * @property int $click5
 * @property int $click6
 * @property int $click7
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereAid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereAllowcomment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereCatid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereClick1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereClick2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereClick3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereClick4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereClick5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereClick6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereClick7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereCollectionNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereCommentNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereContents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereFromurl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereLikeNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereRecommend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostItem whereViewNum($value)
 */
class PostItem extends BaseModel
{
    protected $table = 'post_item';
    protected $primaryKey = 'aid';
    public $timestamps = false;

    public function comment(){
        return $this->hasMany('\App\Models\PostComment','aid','aid');
    }

    /**
     * @param $aid
     */
    public static function deleteAll($aid){
        PostItem::where('aid', $aid)->delete();
        PostContent::where('aid', $aid)->delete();
        PostImage::where('aid', $aid)->delete();
        PostMedia::where('aid', $aid)->delete();
        PostLog::where('aid', $aid)->delete();
        PostComment::where('aid', $aid)->delete();
    }
}
