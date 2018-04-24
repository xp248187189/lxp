<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Admin
 *
 * @property int $id
 * @property string $account 管理员登陆账号
 * @property string $name 管理员姓名
 * @property string $password 管理员登陆密码
 * @property string $phone 手机号
 * @property string $email 邮箱
 * @property int $status 状态
 * @property string $sex 性别
 * @property int $role_id 角色id
 * @property string $role_name 角色名称
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Admin extends Model
{
    //指定表名
    protected $table = 'admin';
    //指定id
    protected $primaryKey = 'id';
}
