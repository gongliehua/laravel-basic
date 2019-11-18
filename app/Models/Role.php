<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

// 角色表
class Role extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['status_text'];

    // 状态
    const STATUS_NORMAL = 1;
    const STATUS_INVALID = 2;
    public $statusLabel = [self::STATUS_NORMAL=>'正常', self::STATUS_INVALID=>'禁用'];
    public function getStatusTextAttribute()
    {
        return isset($this->statusLabel[$this->status]) ? $this->statusLabel[$this->status] : $this->status;
    }

    /**
     * 搜索列表
     * @param $request object 请求信息对象
     * @return mixed 放回查询结果对象
     */
    public static function search($request)
    {
        $list = self::paginate();
        return $list;
    }

    /**
     * 添加
     * @param $data array 数据数组
     * @return bool|string 返回true表示成功,否则失败
     */
    public static function add($data)
    {
        try {
            DB::beginTransaction();

            // 角色信息入库
            $role = new self();
            $role->name = $data['name'];
            $role->status = $data['status'];
            $role->remark = @$data['remark'];
            if (!$role->save()) {
                throw new \Exception('添加失败');
            }

            // 拥有权限入库
            if (isset($data['permission_id']) && is_array($data['permission_id'])) {
                // 防止乱传数据或者是不存在的权限,所有根据传过来的数据从数据表中拿
                $data['permission_id'] = Permission::whereIn('id',$data['permission_id'])->pluck('id');
                foreach ($data['permission_id'] as $val) {
                    $rolePermission = new RolePermission();
                    $rolePermission->role_id = $role->id;
                    $rolePermission->permission_id = $val;
                    if (!$rolePermission->save()) {
                        throw new \Exception('添加失败');
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        return true;
    }

    /**
     * 更新信息
     * @param $id int 角色ID
     * @param $data array 更新的数据
     * @param $permission_id array 拥有的权限ID
     * @return bool tru成功，否则失败
     */
    public static function edit($id, $data, $permission_id)
    {
        try {
            DB::beginTransaction();

            // 更新角色
            $role = self::where([['id','=',$id]])->update($data);
            if (!$role) {
                throw new \Exception('修改失败');
            }

            // 删除原有的权限,重新入库
            RolePermission::where('role_id', $id)->delete();

            // 拥有权限入库
            if (is_array($permission_id)) {
                // 防止乱传数据或者是不存在的权限,所有根据传过来的数据从数据表中拿
                $permission_id = Permission::whereIn('id',$permission_id)->pluck('id');
                foreach ($permission_id as $val) {
                    $rolePermission = new RolePermission();
                    $rolePermission->role_id = $id;
                    $rolePermission->permission_id = $val;
                    if (!$rolePermission->save()) {
                        throw new \Exception('修改失败');
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }


    public static function del($id)
    {
        try {
            DB::beginTransaction();

            // 判断角色是否有管理员使用
            $adminRole = AdminRole::with(['admin'])->where('role_id',$id)->first();
            if ($adminRole) {
                throw new \Exception('该角色有管理员【'.$adminRole->admin->username.'】使用，不能删除！');
            }

            // 删除角色
            $role = self::destroy($id);
            if (!$role) {
                throw new \Exception('删除失败');
            }

            // 删除拥有的权限
            RolePermission::where('role_id', $id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        return true;
    }
}
