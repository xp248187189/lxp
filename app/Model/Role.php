<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Role
 *
 * @property int $id
 * @property string $name 角色名称
 * @property string $auth_ids 权限ids
 * @property int $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereAuthIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    //指定表名
    protected $table = 'role';
    //指定id
    protected $primaryKey = 'id';
}
