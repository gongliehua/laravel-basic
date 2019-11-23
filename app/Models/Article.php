<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

// 文章表
class Article extends Model
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

    // 获取标签
    public function tag()
    {
        return $this->belongsToMany('App\Models\Tag', 'article_tags');
    }

    /**
     * 后台 文章列表
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
        $list = self::where($map)->orderBy('id','desc')->paginate();
        return $list;
    }

    /**
     * 添加
     * @param $data array 添加数据数据
     * @return bool|string 返回true表示成功,放回字符串表示失败
     */
    public static function add($data)
    {
        try {
            DB::beginTransaction();

            // 信息入库
            $article = new self();
            $article->title = $data['title'];
            $article->alias = @$data['alias'];
            $article->author = @$data['author'];
            $article->keywords = @$data['keywords'];
            $article->description = @$data['description'];
            $article->content = $data['content'];
            $article->status = $data['status'];
            if (!$article->save()) {
                throw new \Exception('添加失败');
            }

            // 关联标签入库
            if (isset($data['tag_id']) && is_array($data['tag_id'])) {
                // 防止乱传数据或者是不存在的,所有根据传过来的数据从数据表中拿
                $data['tag_id'] = Tag::whereIn('id',$data['tag_id'])->pluck('id');
                foreach ($data['tag_id'] as $val) {
                    $articleTag = new ArticleTag();
                    $articleTag->article_id = $article->id;
                    $articleTag->tag_id = $val;
                    if (!$articleTag->save()) {
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
     * @param $id int 标签ID
     * @param $data array 更新的数据
     * @param $tag_id array 拥有的标签ID
     * @return bool tru成功,false失败
     */
    public static function edit($id, $data, $tag_id)
    {
        try {
            DB::beginTransaction();

            // 更新
            $article = self::where([['id','=',$id]])->update($data);
            if (!$article) {
                throw new \Exception('修改失败');
            }

            // 删除原有的标签,重新入库
            ArticleTag::where('article_id', $id)->delete();

            // 拥有标签入库
            if (is_array($tag_id)) {
                // 防止乱传数据或者是不存在的,所有根据传过来的数据从数据表中拿
                $tag_id= Tag::whereIn('id',$tag_id)->pluck('id');
                foreach ($tag_id as $val) {
                    $articleTag = new ArticleTag();
                    $articleTag->article_id = $id;
                    $articleTag->tag_id = $val;
                    if (!$articleTag->save()) {
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

    /**
     * 删除
     * @param $id int 文章ID
     * @return bool|string true表示正常,返回字符串失败
     */
    public static function del($id)
    {
        try {
            DB::beginTransaction();

            // 删除
            $article = self::destroy($id);
            if (!$article) {
                throw new \Exception('删除失败');
            }

            // 删除拥有的标签
            ArticleTag::where('article_id', $id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        return true;
    }

    /**
     * 前台 文章列表
     * 搜索字段：title string 非必传 标题
     * @param $request object 请求对象
     * @return mixed object 分页数据对象
     */
    public static function indexSearch($request)
    {
        $map = [];
        if ($request->input('title')) {
            $map[] = ['title','like','%'.$request->input('title').'%'];
        }
        $limit = \App\Libraries\Config::getInstance()->get('limitArticle',15);
        $list = self::select(['id', 'title', 'alias', 'content', 'created_at'])->where($map)->where('status',self::STATUS_SHOW)->orderBy('id','desc')->simplePaginate($limit);
        return $list;
    }

    /**
     * 前台 归档
     * @param $request object 请求对象
     * @return mixed object 分页数据对象
     */
    public static function indexArchives($request)
    {
        $limit = \App\Libraries\Config::getInstance()->get('limitArchive', 15);
        $list = self::select(['id', 'title', 'alias', 'created_at'])->where('status',self::STATUS_SHOW)->orderBy('id','desc')->simplePaginate($limit);
        return $list;
    }

    /**
     * 前台使用
     * @param $id
     * @return array|bool
     */
    public static function frontendDetail($id)
    {
        // id可能是ID,也有可能是别名
        if (is_numeric($id) && strpos($id,'.') === false) {
            $info = self::with(['tag'])->find($id);
        } else {
            $info = self::with(['tag'])->where('alias',$id)->first();
        }
        // 如果存在则继续查询 上/下 一篇文章
        if ($info) {
            $prev = self::select('id','title','alias')->where('id','<',$info->id)->where('status',self::STATUS_SHOW)->orderBy('id','desc')->first();
            $next = self::select('id','title','alias')->where('id','>',$info->id)->where('status',self::STATUS_SHOW)->orderBy('id','asc')->first();
            return ['info'=>$info,'prev'=>$prev,'next'=>$next];
        } else {
            return false;
        }
    }
}
