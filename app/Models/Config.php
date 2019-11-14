<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// 配置表
class Config extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['type_text'];

    // 类型
    const TYPE_TEXT = 1;
    const TYPE_TEXTAREA = 2;
    const TYPE_RADIO = 3;
    const TYPE_CHECKBOX = 4;
    const TYPE_SELECT = 5;
    public $typeLabel = [self::TYPE_TEXT=>'单行文本', self::TYPE_TEXTAREA=>'多行文本', self::TYPE_RADIO=>'单选按钮', self::TYPE_CHECKBOX=>'复选框', self::TYPE_SELECT=>'下拉框'];
    public function getTypeTextAttribute()
    {
        return isset($this->typeLabel[$this->type]) ? $this->typeLabel[$this->type] : $this->type;
    }
}
