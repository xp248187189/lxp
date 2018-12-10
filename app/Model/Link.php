<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Link
 *
 * @property int $id
 * @property string $name 链接名称
 * @property string $url 链接地址
 * @property string $icoUrl favicon.ico图标地址
 * @property int $status 状态
 * @property int $isHome 首页显示
 * @property int $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Link whereIcoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Link whereIsHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Link whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Link whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Link whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Link whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Link whereUrl($value)
 * @mixin \Eloquent
 */
class Link extends Model
{
    //指定表名
    protected $table = 'link';
    //指定id
    protected $primaryKey = 'id';
}
