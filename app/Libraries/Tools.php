<?php

namespace App\Libraries;

use App\Models\AdminRole;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;

/**
 * 辅助工具类
 * 为了性能优化（因为可能在控制器，模型，视图中使用，防止重复创建实例化而浪费内存），不限位置使用，所以使用单例模式
 * 之前考虑到用Traits写，但是如果在视图成中实例化控制器则消耗太大
 * Class Tools
 * @package App\Libraries
 */
class Tools
{
    // 内部实例化变量
    private static $instance;

    // 防止克隆
    private function __clone()
    {
        //
    }

    // 内部初始化
    private function __construct()
    {
        //
    }

    // 获取唯一实例化
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 无限级数组排序
     * @param array $data 未排序过的二维数组,特别提醒下,请使用真数组,如果使用对象数组则可能导致下一次数据排序结果有误
     * @param int $parent_id 父ID
     * @param int $level 等级
     * @param bool $clear 是否清空静态区
     * @return array 排序后的数组
     */
    public function toTwoArray($data = [], $parent_id = 0, $level = 0, $clear = false)
    {
        static $result = [];
        if ($clear) {
            $result = [];
            return $result;
        }
        foreach ($data as $key=>$value) {
            if ($value['parent_id'] == $parent_id) {
                $value['level'] = $level;
                $result[] = $value;
                $this->toTwoArray($data, $value['id'], $level + 1);
            }
        }
        return $result;
    }

    /**
     * 无限级数组转换成多维数组
     * @param array $data 无限级二维数组
     * @param int $parent_id 父ID
     * @return array 转换后的多维数组
     */
    public function toMultiArray($data = [], $parent_id = 0)
    {
        $result = [];
        foreach ($data as $key=>$value) {
            if ($value['parent_id'] == $parent_id) {
                $value['child'] = $this->toMultiArray($data, $value['id']);
                $result[] = $value;
            }
        }
        return $result;
    }

    /**
     * 无限级多维数组转换成菜单字符串
     * @param array $data 无限级多维数组
     * @return string 返回菜单HTML
     */
    public function toMenuHtml($data = [])
    {
        $result = '';
        foreach ($data as $key=>$value) {
            if (empty($value['child'])) {
                $aTag  = '<a href="/'. $value['path'] .'"><i class="menu-icon fa '. $value['icon'] .'"></i><span class="menu-text">'. $value['title'] .'</span></a><b class="arrow"></b>';
            } else {
                $aTag  = '<a href="'. $value['path'] .'" class="dropdown-toggle"><i class="menu-icon fa '. $value['icon'] .'"></i><span class="menu-text">'. $value['title'] .'</span><b class="arrow fa fa-angle-down"></b></a><b class="arrow"></b>';
            }
            $result .= '<li class="">'.$aTag;
            if (!empty($value['child'])) {
                $result .= '<ul class="submenu">'. $this->toMenuHtml($value['child']) .'</ul>';
            }
            $result .= '</li>';
        }
        return $result;
    }

    /**
     * 无限级获取上级
     * @param array $data 无限级数组
     * @param int $id 当前ID
     * @return array 上级数组
     */
    public function getParents($data = [], $id)
    {
        $result = [];
        foreach ($data as $val) {
            if ($val['id'] == $id) {
                $result[] = $val;
                $result = array_merge($this->getParents($data, $val['parent_id']),$result);
            }
        }
        return $result;
    }

    /**
     * 加密函数
     * @param string $data 需要加密的字符串
     * @param string $key 加密时用的KEY
     * @return string 返回加密后的字符串
     */
    public function setPassword($data, $key)
    {
        $key    = md5(md5(md5($key)));
        $x      = 0;
        $len    = strlen($data);
        $l      = strlen($key);
        $char   = "";
        $str    = "";
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) {
                $x = 0;
            }
            $char .= $key{$i};
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
        }
        return base64_encode($str);
    }

    /**
     * 解密函数,和加密函数配合使用
     * @param string $data 被加密的字符串
     * @param string $key 解密用的KEY
     * @return string 返回解密后的字符串
     */
    public function getPassword($data, $key)
    {
        $data   = base64_decode($data);
        $key    = md5(md5(md5($key)));
        $x      = 0;
        $len    = strlen($data);
        $l      = strlen($key);
        $str    = "";
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) {
                $x = 0;
            }
            $str .= chr(ord($data{$i}) - ord($key{$i}) % 256);
            $x++;
        }
        return $str;
    }

    /**
     * curl函数,一般用于POST请求
     * @param string $url URL地址
     * @param array $data 请求数据
     * @return mixed 请求结果
     */
    public function curlPost($url, $data = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if ($data) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

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
        // 转数组
        $permissions = json_decode(json_encode($permissions), true);
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
        $permissions = json_decode(json_encode($permissions), true);
        $permissions = $this->toTwoArray($permissions);
        $this->toTwoArray([], 0, 0, true);
        return $permissions;
    }
}
