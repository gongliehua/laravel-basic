<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// 权限表
class Permission extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['is_menu_text', 'status_text'];

    // 显示到菜单栏
    const IS_MENU_YES = 1;
    const IS_MENU_NO = 2;
    public $is_menuLabel = [self::IS_MENU_YES=>'是', self::IS_MENU_NO=>'不是'];
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
}
