<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminRole;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Traits\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

// 基类控制器
class BaseController extends Controller
{
    use Helper;

    // 构建导航
    public function buildMenu()
    {
        // 默认管理员不受限制
        if (Auth::guard('admin')->id() == 1) {
            // 获取权限(显示到到导航栏的,状态为正常的)
            $permissions = Permission::where('is_menu', Permission::IS_MENU_YES)->where('status', Permission::STATUS_NORMAL)->get();
        } else {
            // 获取当前用户角色
            $roleId = AdminRole::where('admin_id', Auth::guard('admin')->id())->value('role_id');

            // 获取角色拥有的权限(显示到到导航栏的,状态为正常的)
            $permissionIds = RolePermission::where('role_id', $roleId)->pluck('permission_id');
            $permissions = Permission::where('is_menu', Permission::IS_MENU_YES)->where('status', Permission::STATUS_NORMAL)->whereIn('id', $permissionIds)->get();
        }
        // 排序
        $permissions = $this->toTwoArray($permissions);
        $this->toTwoArray([], 0, 0, true);
        // 转换成多维数组
        $permissions = $this->toMultiArray($permissions);
        // 转换成HTML
        $permissions = $this->toMenuHtml($permissions);
        return '<ul class="nav nav-list">'.$permissions.'</ul>';
    }
}
