<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Notice
 *
 * @property int $id
 * @property string $content 内容
 * @property int $status 状态
 * @property int $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Notice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Notice query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Notice whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Notice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Notice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Notice whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Notice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Notice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Notice extends Model
{
    //指定表名
    protected $table = 'notice';
    //指定id
    protected $primaryKey = 'id';
}
