<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\User
 *
 * @property int $id
 * @property string $account 用户名
 * @property string $sex 性别
 * @property string $head 头像
 * @property string $connectid qq登录返回的id
 * @property int $addTime 加入时间
 * @property int $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereAddTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereConnectid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereHead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Model
{
    //指定表名
    protected $table = 'user';
    //指定id
    protected $primaryKey = 'id';
}
