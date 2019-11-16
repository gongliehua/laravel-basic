<?php

namespace App\Libraries;

use App\Models\AdminRole;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;

/**
 * 工具类
 * 写复杂性的东西,写和框架先关的东西
 * 任何位置可调用,包括不限于控制器,模型,试图层
 * Class Tools
 * @package App\Libraries
 */
class Tools extends Helper
{
    /**
     * Laravel文件上传
     * @param object $file File对象
     * @param string $dir 目录
     * @param array $exceptExtends 排除文件扩展名
     * @return array 返回出来结果
     */
    public static function fileUpload($file, $dir = '', $exceptExtends = [])
    {
        if ($file) {
            $fileName = sha1(uniqid(null, true));
            $fileExtends = $file->getClientOriginalExtension();
            $uploadDir = ($dir != '') ? public_path($dir) : public_path();
            if (!is_dir($uploadDir)) {
                @mkdir($uploadDir, 0777);
            }
            if (!is_writeable($uploadDir)) {
                return ['code'=>1, 'msg'=>'上传目录不可写', 'data'=>[]];
            }
            $url = trim(str_replace('\\','/',trim(trim($dir,'/'),'\\').'\\'.$fileName.'.'.$fileExtends),'/');
            if (in_array($fileExtends, $exceptExtends)) {
                return ['code'=>1, 'msg'=>'该文件类型禁止上传', 'data'=>[]];
            }
            if ($file->move($uploadDir, $fileName.'.'.$fileExtends)) {
                return ['code'=>0, 'msg'=>'上传成功', 'data'=>$url];
            } else {
                return ['code'=>1, 'msg'=>'上传失败', 'data'=>[]];
            }
        } else {
            return ['code'=>1, 'msg'=>'请上传文件', 'data'=>[]];
        }
    }

    /**
     * 构建导航
     * @return string 返回菜单HTML
     */
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

    /**
     * 所有权限
     * @return array 返回排序过后的所有权限
     */
    public function allPermission()
    {
        $permissions = Permission::orderBy('order', 'asc')->get();
        $permissions = $this->toTwoArray($permissions);
        $this->toTwoArray([], 0, 0, true);
        return $permissions;
    }
}
