<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Category
 *
 * @property int $id
 * @property string $name 分类名称
 * @property int $sort 排序
 * @property int $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    //指定表名
    protected $table = 'category';
    //指定id
    protected $primaryKey = 'id';
}
