<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

// 管理员表
class Admin extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['sex_text', 'status_text'];

    // 性别
    const SEX_NO = 0;
    const SEX_MAN = 1;
    const SEX_GIRL = 2;
    public $sexLabel = [self::SEX_NO=>'未知', self::SEX_MAN=>'男', self::SEX_GIRL=>'女'];
    public function getSexTextAttribute()
    {
        return isset($this->sexLabel[$this->sex]) ? $this->sexLabel[$this->sex] : $this->sex;
    }

    // 状态
    const STATUS_NORMAL = 1;
    const STATUS_INVALID = 2;
    public $statusLabel = [self::STATUS_NORMAL=>'正常', self::STATUS_INVALID=>'禁用'];
    public function getStatusTextAttribute()
    {
        return isset($this->statusLabel[$this->status]) ? $this->statusLabel[$this->status] : $this->status;
    }

    // 获取角色(暂时不使用多对多)
    public function adminRole()
    {
        return $this->belongsToMany('App\Models\Role', 'admin_roles');
    }

    // 获取角色
    public function adminRoleOne()
    {
        return $this->hasOne('App\Models\AdminRole');
    }

    /**
     * 登录验证用户名和密码
     * @param $username string 用户名
     * @param $password string 密码
     * @return string|object 返回结果
     */
    public static function verifyUserNamePassword($username, $password)
    {
        $admin = self::where('username', $username)->where('password', sha1($password))->first();
        return $admin ? $admin : '用户名或密码错误';
    }

    /**
     * 修改信息
     * @param $where array 条件数组
     * @param $data array 更新条件数组
     * @return mixed int 返回修改行数
     */
    public static function edit($where, $data)
    {
        $admin = self::where($where)->update($data);
        return $admin;
    }

    /**
     * 管理员搜索（通过sex性别,status状态,name用户名或昵称搜索）
     * @param $request object Request对象
     * @return mixed object 搜索结果
     */
    public static function search($request)
    {
        $map = [];
        // 性别
        if (!in_array($request->input('sex'),[null,''])) {
            $map[] = ['sex','=',$request->input('sex')];
        }
        // 状态
        if (!in_array($request->input('status'),[null,''])) {
            $map[] = ['status','=',$request->input('status')];
        }
        $result = self::with(['adminRoleOne'=>function($query){
            $query->with(['role']);
        }])->where($map)->when($request->input('name'), function($query) use($request) {
            $query->where('username','like','%'.$request->input('name').'%')->orWhere('name','like','%'.$request->input('name').'%');
        })->paginate();
        return $result;
    }

    /**
     * 添加
     * @param $data array 数据数组
     * @return bool true成功,否则失败
     */
    public static function add($data)
    {
        try {
            DB::beginTransaction();

            // 管理员入库
            $admin = new self();
            $admin->username = $data['username'];
            $admin->password = $data['password'];
            $admin->name = $data['name'];
            $admin->sex = $data['sex'];
            $admin->status = $data['status'];
            $admin->avatar = @$data['avatar'];
            if (!$admin->save()) {
                throw new \Exception('添加失败');
            }

            // 角色入库
            $adminRole = new AdminRole();
            $adminRole->admin_id = $admin->id;
            $adminRole->role_id = $data['role_id'];
            if (!$adminRole->save()) {
                throw new \Exception('添加失败');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * 更新单条管理员信息
     * @param $id int 管理员id
     * @param $data array 需要更新数据的数组
     * @param $role_id int 角色ID
     * @return bool true成功，否则失败
     */
    public static function editInfo($id, $data, $role_id)
    {
        try {
            DB::beginTransaction();

            // 更新信息
            $admin = self::where('id',$id)->update($data);
            if (!$admin) {
                throw new \Exception('修改失败');
            }

            // 删除原角色
            AdminRole::where('admin_id',$id)->delete();

            // 添加角色关系
            $adminRole = new AdminRole();
            $adminRole->admin_id = $id;
            $adminRole->role_id = $role_id;
            if (!$adminRole->save()) {
                throw new \Exception('修改失败');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * 删除管理员
     * @param $id int 管理员ID
     * @return bool true表示成功，否则失败
     */
    public static function del($id)
    {
        try {
            DB::beginTransaction();

            // 删除
            $admin = self::destroy($id);
            if (!$admin) {
                throw new \Exception('删除失败');
            }

            // 删除原角色
            AdminRole::where('admin_id',$id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }
}
