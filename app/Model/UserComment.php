<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserComment extends Model
{
    //指定表名
    protected $table = 'user_comment';
    //指定id
    protected $primaryKey = 'id';
}
