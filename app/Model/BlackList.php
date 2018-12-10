<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\BlackList
 *
 * @property int $id
 * @property string $ip ip地址
 * @property int $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BlackList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BlackList query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BlackList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BlackList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BlackList whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BlackList whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BlackList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BlackList extends Model
{
    //指定表名
    protected $table = 'black_list';
    //指定id
    protected $primaryKey = 'id';
}
