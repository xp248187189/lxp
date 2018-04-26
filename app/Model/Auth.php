<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    //指定表名
    protected $table = 'auth';
    //指定id
    protected $primaryKey = 'id';
}
