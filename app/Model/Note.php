<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //指定表名
    protected $table = 'note';
    //指定id
    protected $primaryKey = 'id';
}
