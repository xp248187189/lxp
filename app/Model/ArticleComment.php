<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\ArticleComment
 *
 * @property int $id
 * @property int $article_id 文章id
 * @property string $article_name 文章标题
 * @property int $user_id 用户id
 * @property string $user_account 用户名
 * @property string $user_head 用户头像
 * @property int $time 评论时间
 * @property string|null $connect 评论内容
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ArticleComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ArticleComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ArticleComment whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ArticleComment whereArticleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ArticleComment whereConnect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ArticleComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ArticleComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ArticleComment whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ArticleComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ArticleComment whereUserAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ArticleComment whereUserHead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ArticleComment whereUserId($value)
 * @mixin \Eloquent
 */
class ArticleComment extends Model
{
    //指定表名
    protected $table = 'article_comment';
    //指定id
    protected $primaryKey = 'id';
}
