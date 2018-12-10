<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Article
 *
 * @property int $id
 * @property string $img 文章主图
 * @property string $title 文章标题
 * @property string $outline 文章概要
 * @property string|null $content 文章内容
 * @property int $category_id 分类id
 * @property string $category_name 分类名称
 * @property int $isHome 是否首页
 * @property int $isRecommend 是否推荐
 * @property int $sort 排序
 * @property int $status 状态
 * @property string $author 作者
 * @property string $addDate 添加日期
 * @property int $showNum 浏览次数
 * @property int $commentCount 评论数
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereAddDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereCommentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereIsHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereIsRecommend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereOutline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereShowNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    //指定表名
    protected $table = 'article';
    //指定id
    protected $primaryKey = 'id';
    //关联评论表
    public function getCommentCount(){
        return $this->hasMany('App\Model\ArticleComment');
    }
}
