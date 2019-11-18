<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 角色权限表
class RolePermission extends Model
{
    // 获取角色
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
}
