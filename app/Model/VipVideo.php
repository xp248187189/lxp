<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\VipVideo
 *
 * @property int $id
 * @property string $name 名称
 * @property string $url URL
 * @property int $type 类型（1[api]，2[播放地址]）
 * @property int $status 状态
 * @property int $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VipVideo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VipVideo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VipVideo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VipVideo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VipVideo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VipVideo whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VipVideo whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VipVideo whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VipVideo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VipVideo whereUrl($value)
 * @mixin \Eloquent
 */
class VipVideo extends Model
{
    //指定表名
    protected $table = 'vip_video';
    //指定id
    protected $primaryKey = 'id';
}
