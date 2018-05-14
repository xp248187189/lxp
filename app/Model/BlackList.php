<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    //指定表名
    protected $table = 'black_list';
    //指定id
    protected $primaryKey = 'id';
}
