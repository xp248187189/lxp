<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    //指定表名
    protected $table = 'article_comment';
    //指定id
    protected $primaryKey = 'id';
}
