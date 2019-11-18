<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 管理员角色表
class AdminRole extends Model
{
    // 获取管理员
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }

    // 获取角色
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
}
