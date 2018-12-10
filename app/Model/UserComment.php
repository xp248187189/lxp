<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\UserComment
 *
 * @property int $id
 * @property int $pid 父id
 * @property int $user_id 用户id
 * @property string $user_account 用户名
 * @property string $user_head 用户头像
 * @property int $time 留言时间
 * @property string|null $connect 留言内容
 * @property int $huifuCount 回复数
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserComment whereConnect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserComment whereHuifuCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserComment wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserComment whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserComment whereUserAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserComment whereUserHead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserComment whereUserId($value)
 * @mixin \Eloquent
 */
class UserComment extends Model
{
    //指定表名
    protected $table = 'user_comment';
    //指定id
    protected $primaryKey = 'id';
}
