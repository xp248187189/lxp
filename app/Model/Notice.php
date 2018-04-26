<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    //指定表名
    protected $table = 'notice';
    //指定id
    protected $primaryKey = 'id';
}
