<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\TimeAxis
 *
 * @property int $id
 * @property int $year 年
 * @property int $month 月
 * @property int $day 日
 * @property int $hour 时
 * @property int $minute 分
 * @property string|null $content 内容
 * @property int $status 状态
 * @property int $isHome 首页显示
 * @property int $time 时间戳
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis whereHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis whereIsHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis whereMinute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TimeAxis whereYear($value)
 * @mixin \Eloquent
 */
class TimeAxis extends Model
{
    //指定表名
    protected $table = 'time_axis';
    //指定id
    protected $primaryKey = 'id';
}
