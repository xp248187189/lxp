<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //指定表名
    protected $table = 'role';
    //指定id
    protected $primaryKey = 'id';
}
