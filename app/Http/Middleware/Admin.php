<?php

namespace App\Http\Middleware;

use App\Models\AdminRole;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 判断是否登录
        if (!Auth::guard('admin')->check()) {
            return redirect('admin/login');
        }
        // 判断是否有权限
        $path = $request->path(); //当前路由
        $exceptPath = ['admin/index', 'admin/profile']; //排除基本路由
        $userInfo = Auth::guard('admin')->user(); // 当前用户信息
        if (!in_array($path, $exceptPath)) {
            // 排除默认管理员
            if ($userInfo['id'] != 1) {
                // 判断当前用户状态
                if ($userInfo['status'] != \App\Models\Admin::STATUS_NORMAL) {
                    return redirect('admin/index')->withErrors(['error'=>'账户已被禁用！']);
                }
                // 获取权限信息
                $permissionId = Permission::where('path',$path)->where('status',Permission::STATUS_NORMAL)->value('id');
                if (!$permissionId) {
                    return redirect('admin/index')->withErrors(['error'=>'拒绝访问，未检索到该权限！']);
                }
                // 获取角色信息
                $roleId = AdminRole::where('admin_id',$userInfo['id'])->value('role_id');
                $roleId = Role::where('id',$roleId)->where('status', Role::STATUS_NORMAL)->value('id');
                if (!$roleId) {
                    return redirect('admin/index')->withErrors(['error'=>'拒绝访问，您没有访问权限！']);
                }
                // 判断角色是否有该权限
                $rolePermissionId = RolePermission::where('role_id',$roleId)->where('permission_id',$permissionId)->value('id');
                if (!$rolePermissionId) {
                    return redirect('admin/index')->withErrors(['error'=>'拒绝访问，您没有访问权限！']);
                }
            }
        }
        return $next($request);
    }
}
