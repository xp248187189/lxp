<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //指定表名
    protected $table = 'admin';
    //指定id
    protected $primaryKey = 'id';
}
