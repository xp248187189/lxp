<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\AdminLogin
 *
 * @property int $id
 * @property string $ip 登录ip
 * @property int $time 登录时间
 * @property string $account 登录名
 * @property string $browser 浏览器信息
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AdminLogin whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AdminLogin whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AdminLogin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AdminLogin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AdminLogin whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AdminLogin whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AdminLogin whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $account_id 登陆id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AdminLogin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AdminLogin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AdminLogin whereAccountId($value)
 */
class AdminLogin extends Model
{
    //指定表名
    protected $table = 'admin_login';
    //指定id
    protected $primaryKey = 'id';
}
