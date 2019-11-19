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

    /**
     * 搜索列表
     * @param $request object request对象
     * @return mixed 返回对象数组
     */
    public static function search($request)
    {
        $list = self::paginate();
        return $list;
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
     * 删除
     * @param $id int 配置ID
     * @return int
     */
    public static function del($id)
    {
        $config = self::destroy($id);
        return $config;
    }

    /**
     * 添加
     * @param $data array 添加的数据
     * @return bool|mixed false表示失败，int表示成功
     */
    public static function add($data)
    {
        $config = new self();
        $config->title = $data['title'];
        $config->variable = $data['variable'];
        $config->type = $data['type'];
        $config->item = @$data['item'];
        $config->value = @$data['value'];
        $config->order = $data['order'];
        if ($config->save()) {
            return $config->id;
        } else {
            return false;
        }
    }

    // 修改
    public static function edit($id, $data)
    {
        $config = self::where('id',$id)->update($data);
        return $config;
    }

    /**
     * 设置
     * @param $data array 数据数组,key是id,value是值
     */
    public static function setting($data)
    {
        // 只能按数据表来循环,因为checkbox框可能一个都没选,也就是什么都没传过来
        $list = Config::all();
        foreach ($list as $value) {
            // 判断是否传值，否则就清空配置值
            if (isset($data[$value->id])) {
                // 如果传过来的是数组,就通过,分隔
                if (is_array($data[$value->id])) {
                   self::where('id',$value->id)->update(['value'=>implode(',',$data[$value->id])]);
                } else {
                    self::where('id',$value->id)->update(['value'=>$data[$value->id]]);
                }
            } else {
                // 没传值则清空配置值
                self::where('id',$value->id)->update(['value'=>null]);
            }
        }
    }
}
