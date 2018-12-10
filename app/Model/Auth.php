<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Auth
 *
 * @property int $id
 * @property int $pid 父级id
 * @property string $id_list 顶级id至本身id
 * @property int $level 级别
 * @property int $sort 排序
 * @property string $name 权限名称
 * @property string $controller 控制器
 * @property string $action 方法
 * @property string $icon 图标
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth whereController($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth whereIdList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Auth extends Model
{
    //指定表名
    protected $table = 'auth';
    //指定id
    protected $primaryKey = 'id';
}
