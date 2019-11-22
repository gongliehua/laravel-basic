<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// 文章控制器
class ArticleController extends BaseController
{
    // 列表
    public function index(Request $request)
    {
        $list = Article::search($request);
        return view('admin.article.index',['list'=>$list]);
    }

    // 添加
    public function create(Request $request)
    {
        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title'=>'required|string|between:1,255',
                'alias'=>[
                    function ($attribute,$value,$fail) use($request) {
                        // 存在则判断
                        if (strlen($value)) {
                            $validAlias = Validator::make($request->all(), [
                                'alias'=>[
                                    'string',
                                    'between:1,32',
                                    Rule::unique('articles')->where(function($query){
                                        $query->whereNull('deleted_at');
                                    })
                                ],
                            ], [], [
                                'alias'=>'别名'
                            ]);
                            if ($validAlias->fails()) {
                                return $fail($validAlias->errors()->first());
                            }
                        }
                    },
                ],
                'author'=>[
                    function($attribute,$value,$fail){
                        if (!in_array($value,[null,''])) {
                            if (mb_strlen($value,'UTF-8') > 32) {
                                return $fail('作者长度不能超过32个字符');
                            }
                        }
                    },
                ],
                'keywords'=>[
                    function($attribute,$value,$fail){
                        if (!in_array($value,[null,''])) {
                            if (mb_strlen($value,'UTF-8') > 255) {
                                return $fail('关键词长度不能超过255个字符');
                            }
                        }
                    },
                ],
                'description'=>[
                    function($attribute,$value,$fail){
                        if (!in_array($value,[null,''])) {
                            if (mb_strlen($value,'UTF-8') > 255) {
                                return $fail('描述长度不能超过255个字符');
                            }
                        }
                    },
                ],
                'content'=>'required|string',
                'status'=>'required|integer',
            ], [], [
                'title'=>'标题',
                'alias'=>'别名',
                'author'=>'作者',
                'keywords'=>'关键词',
                'description'=>'描述',
                'content'=>'内容',
                'status'=>'状态',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 获取数据
            $data = $request->only(['title','keywords','description','content','status','author','tag_id','alias']);

            // 入库
            $article = Article::add($data);
            if ($article === true) {
                return redirect('admin/article/index')->withErrors(['success'=>'添加成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'添加失败']);
            }
        }

        $tags = Tag::orderBy('order','asc')->get();
        return view('admin.article.create',['tags'=>$tags]);
    }

    // 查看
    public function show(Request $request)
    {
        $article = Article::find($request->input('id'));
        if (!$article) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }
        $inIds = ArticleTag::where('article_id',$request->input('id'))->pluck('tag_id');
        $inIds = json_decode(json_encode($inIds),true);
        $tags = Tag::orderBy('order','asc')->get();
        return view('admin.article.show',['article'=>$article,'inIds'=>$inIds,'tags'=>$tags]);
    }

    // 修改
    public function update(Request $request)
    {
        // 基本信息
        $article = Article::find($request->input('id'));
        if (!$article) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }

        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'id'=>'required|integer',
                'alias'=>[
                    function ($attribute,$value,$fail) use($request) {
                        // 存在则判断
                        if (strlen($value)) {
                            $validAlias = Validator::make($request->all(), [
                                'alias'=>[
                                    'string',
                                    'between:1,32',
                                    Rule::unique('articles')->where(function($query) use($request) {
                                        $query->whereNull('deleted_at')->where('id','<>',$request->input('id'));
                                    })
                                ],
                            ], [], [
                                'alias'=>'别名'
                            ]);
                            if ($validAlias->fails()) {
                                return $fail($validAlias->errors()->first());
                            }
                        }
                    },
                ],
                'title'=>'required|string|between:1,255',
                'author'=>[
                    function($attribute,$value,$fail){
                        if (!in_array($value,[null,''])) {
                            if (mb_strlen($value,'UTF-8') > 32) {
                                return $fail('作者长度不能超过32个字符');
                            }
                        }
                    },
                ],
                'keywords'=>[
                    function($attribute,$value,$fail){
                        if (!in_array($value,[null,''])) {
                            if (mb_strlen($value,'UTF-8') > 255) {
                                return $fail('关键词长度不能超过255个字符');
                            }
                        }
                    },
                ],
                'description'=>[
                    function($attribute,$value,$fail){
                        if (!in_array($value,[null,''])) {
                            if (mb_strlen($value,'UTF-8') > 255) {
                                return $fail('描述长度不能超过255个字符');
                            }
                        }
                    },
                ],
                'content'=>'required|string',
                'status'=>'required|integer',
            ], [], [
                'id'=>'ID',
                'author'=>'作者',
                'title'=>'标题',
                'alias'=>'别名',
                'keywords'=>'关键词',
                'description'=>'描述',
                'content'=>'内容',
                'status'=>'状态',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 获取数据
            $data = $request->only(['title','keywords','description','content','status','author','alias']);

            // 入库
            $article = Article::edit($request->input('id'),$data,$request->input('tag_id'));
            if ($article) {
                return redirect('admin/article/index')->withErrors(['success'=>'修改成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'修改失败']);
            }
        }
        $inIds = ArticleTag::where('article_id',$request->input('id'))->pluck('tag_id');
        $inIds = json_decode(json_encode($inIds),true);
        $tags = Tag::orderBy('order','asc')->get();
        return view('admin.article.update',['article'=>$article,'inIds'=>$inIds,'tags'=>$tags]);
    }

    // 删除
    public function delete(Request $request)
    {
        $article = Article::del($request->input('id'));
        if ($article) {
            return back()->withInput()->withErrors(['success'=>'删除成功']);
        } else {
            return back()->withInput()->withErrors(['error'=>'删除失败']);
        }
    }
}
