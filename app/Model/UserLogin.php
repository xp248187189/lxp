<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\UserLogin
 *
 * @property int $id
 * @property string $ip 登录ip
 * @property int $time 登录时间
 * @property int $account_id 登陆id
 * @property string $account 登录名
 * @property string|null $browser 浏览器信息
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserLogin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserLogin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserLogin whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserLogin whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserLogin whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserLogin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserLogin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserLogin whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserLogin whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserLogin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserLogin extends Model
{
    //指定表名
    protected $table = 'user_login';
    //指定id
    protected $primaryKey = 'id';
}
