<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

// 标签表
class Tag extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    // 获取文章
    public function article()
    {
        return $this->belongsToMany('App\Models\Article', 'article_tags');
    }

    /**
     * 搜索列表
     * @param $request object 请求信息对象
     * @return mixed 放回查询结果对象
     */
    public static function search($request)
    {
        $list = self::orderBy('order','asc')->paginate();
        return $list;
    }


    /**
     * 添加
     * @param $data array 数据数组
     * @return bool true成功，false失败
     */
    public static function add($data)
    {
        $tag = new self();
        $tag->name = $data['name'];
        $tag->order = $data['order'];
        if (!$tag->save()) {
            return false;
        }
        return true;
    }

    /**
     * 更新
     * @param $id int 标签ID
     * @param $data array 更新数据
     * @return bool true表示成功,false失败
     */
    public static function edit($id, $data)
    {
        $role = self::where([['id','=',$id]])->update($data);
        if (!$role) {
            return false;
        }
        return true;
    }

    /**
     * 删除标签
     * @param $id int 标签ID
     * @return bool|string true表示删除成功，字符串表示删除失败
     */
    public static function del($id)
    {
        // 判断是否有文章使用
        $articleTag = ArticleTag::with(['article'])->where('tag_id',$id)->first();
        if ($articleTag) {
            return '该标签有文章【'.$articleTag->article->title.'】使用，不能删除！';
        }

        // 删除标签
        $delTag = self::destroy($id);
        if (!$delTag) {
            return '删除失败';
        }
        return true;
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
}
