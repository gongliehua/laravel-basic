<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

// 页面表
class Page extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['status_text'];

    // 状态
    const STATUS_SHOW = 1;
    const STATUS_HIDE = 2;
    public $statusLabel = [self::STATUS_SHOW=>'显示', self::STATUS_HIDE=>'隐藏'];
    public function getStatusTextAttribute()
    {
        return isset($this->statusLabel[$this->status]) ? $this->statusLabel[$this->status] : $this->status;
    }

    /**
     * 后台 列表
     * 搜索字段：title string 非必传 标题
     * 搜索字段：status int 非必传 状态
     * @param $request object 请求对象
     * @return mixed object 分页数据对象
     */
    public static function search($request)
    {
        $map = [];
        if ($request->input('title')) {
            $map[] = ['title','like','%'.$request->input('title').'%'];
        }
        if ($request->input('status')) {
            $map[] = ['status','=',$request->input('status')];
        }
        $list = self::where($map)->orderBy('order','asc')->paginate();
        return $list;
    }

    /**
     * 添加
     * @param $data array 添加数据数据
     * @return bool 返回true表示成功,放回false表示失败
     */
    public static function add($data)
    {
        $page = new self();
        $page->title = $data['title'];
        $page->alias = @$data['alias'];
        $page->keywords = @$data['keywords'];
        $page->description = @$data['description'];
        $page->content = $data['content'];
        $page->status = $data['status'];
        $page->order = $data['order'];
        if (!$page->save()) {
            return false;
        }
        return true;
    }

    /**
     * 更新信息
     * @param $id int 标签ID
     * @param $data array 更新的数据
     * @return bool tru成功,false失败
     */
    public static function edit($id, $data)
    {
        $page = self::where([['id','=',$id]])->update($data);
        if (!$page) {
            return false;
        }
        return true;
    }

    /**
     * 删除
     * @param $id int 文章ID
     * @return bool true表示正常,返回false失败
     */
    public static function del($id)
    {
        $article = self::destroy($id);
        if (!$article) {
            return false;
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
