<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 文章标签表
class ArticleTag extends Model
{
    // 获取文章
    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

    // 获取标签
    public function tag()
    {
        return $this->belongsTo('App\Models\Tag');
    }
}
