<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
