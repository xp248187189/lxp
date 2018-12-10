<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\BingImg
 *
 * @property int $id
 * @property string $date 日期
 * @property string $url url地址
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BingImg newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BingImg query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BingImg whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BingImg whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BingImg whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BingImg whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BingImg whereUrl($value)
 * @mixin \Eloquent
 */
class BingImg extends Model
{
    //指定表名
    protected $table = 'bing_img';
    //指定id
    protected $primaryKey = 'id';
}
