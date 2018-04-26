<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    //指定表名
    protected $table = 'user_login';
    //指定id
    protected $primaryKey = 'id';
}
