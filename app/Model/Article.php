<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //指定表名
    protected $table = 'article';
    //指定id
    protected $primaryKey = 'id';
}
