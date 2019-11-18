<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    // 获取角色
    public function adminRole()
    {
        return $this->belongsToMany('App\Models\Role', 'admin_roles');
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
     * 修改
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
        if (!in_array($request->input('sex'),[null,''])) {
            $map[] = ['sex','=',$request->input('sex')];
        }
        if (!in_array($request->input('status'),[null,''])) {
            $map[] = ['status','=',$request->input('status')];
        }
        $result = self::where($map)->when($request->input('name'), function($query) use($request) {
            $query->where('username','like','%'.$request->input('name').'%')->orWhere('name','like','%'.$request->input('name').'%');
        })->paginate();
        return $result;
    }
}
