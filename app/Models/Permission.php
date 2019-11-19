<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

// 权限表
class Permission extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['is_menu_text', 'status_text'];

    // 显示到菜单栏
    const IS_MENU_YES = 1;
    const IS_MENU_NO = 2;
    public $is_menuLabel = [self::IS_MENU_NO=>'否', self::IS_MENU_YES=>'是'];
    public function getIsMenuTextAttribute()
    {
        return isset($this->is_menuLabel[$this->is_menu]) ? $this->is_menuLabel[$this->is_menu] : $this->is_menu;
    }

    // 状态
    const STATUS_NORMAL = 1;
    const STATUS_INVALID = 2;
    public $statusLabel = [self::STATUS_NORMAL=>'正常', self::STATUS_INVALID=>'禁用'];
    public function getStatusTextAttribute()
    {
        return isset($this->statusLabel[$this->status]) ? $this->statusLabel[$this->status] : $this->status;
    }

    // 获取父权限
    public function permission()
    {
        return $this->belongsTo('App\Models\Permission', 'parent_id', 'id');
    }

    /**
     * 排序
     * @param $data array 排序数组,key是id,value是值
     */
    public static function order($data)
    {
        foreach ($data as $key=>$value) {
            self::where('id', (int)$key)->update(['order'=>(int)$value]);
        }
    }

    /**
     * 添加数据
     * @param $data array 添加的数据
     * @return int/null 成功返回自增ID,方便返回null
     */
    public static function add($data)
    {
        $permission = new self();
        $permission->parent_id = $data['parent_id'];
        $permission->icon = @$data['icon'];
        $permission->title = $data['title'];
        $permission->path = @$data['path'];
        $permission->is_menu = $data['is_menu'];
        $permission->status = $data['status'];
        $permission->order = $data['order'];
        $permission->remark = @$data['remark'];
        return $permission->save() ? $permission->id : null;
    }

    /**
     * 修改
     * @param $where array 条件数组
     * @param $data array 更新条件数组
     * @return mixed int 返回修改行数
     */
    public static function edit($where, $data)
    {
        $permission = self::where($where)->update($data);
        return $permission;
    }

    /**
     * 删除数据
     * @param $id
     * @return bool|string
     */
    public static function del($id)
    {
        try {
            DB::beginTransaction();

            $rolePermission = RolePermission::with(['role'])->where('permission_id',$id)->first();
            if ($rolePermission) {
                throw new \Exception('该权限有角色【'.$rolePermission->role->name.'】使用，不能删除！');
            }
            $permission = self::destroy($id);
            if (!$permission) {
                throw new \Exception('删除失败，请刷新页面后重试！');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        return true;
    }
}
