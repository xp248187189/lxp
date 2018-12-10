<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Note
 *
 * @property int $id
 * @property string $title 标题
 * @property string $url url地址
 * @property string $account 账号
 * @property string $password 密码
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Note query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Note whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Note wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Note whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Note whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Note whereUrl($value)
 * @mixin \Eloquent
 */
class Note extends Model
{
    //指定表名
    protected $table = 'note';
    //指定id
    protected $primaryKey = 'id';
}
