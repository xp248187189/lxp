<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //指定表名
    protected $table = 'user';
    //指定id
    protected $primaryKey = 'id';
}
