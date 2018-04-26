<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //指定表名
    protected $table = 'category';
    //指定id
    protected $primaryKey = 'id';
}
