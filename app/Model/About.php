<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\About
 *
 * @property int $id
 * @property string $name 名称
 * @property string $introduce 简介
 * @property string|null $detail 详情
 * @property string $label 标签
 * @property string $img 图片
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\About newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\About query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\About whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\About whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\About whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\About whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\About whereIntroduce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\About whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\About whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\About whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class About extends Model
{
    //指定表名
    protected $table = 'about';
    //指定id
    protected $primaryKey = 'id';
}
