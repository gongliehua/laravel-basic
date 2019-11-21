<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// 页面控制器
class PageController extends BaseController
{
    // 列表
    public function index(Request $request)
    {
        $list = Page::search($request);
        return view('admin.page.index',['list'=>$list]);
    }

    // 添加
    public function create(Request $request)
    {
        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title'=>'required|string|between:1,255',
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
                'order'=>'required|integer',
            ], [], [
                'title'=>'标题',
                'keywords'=>'关键词',
                'description'=>'描述',
                'content'=>'内容',
                'status'=>'状态',
                'order'=>'排序',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 获取数据
            $data = $request->only(['title','keywords','description','content','status','order']);

            // 入库
            $page = Page::add($data);
            if ($page) {
                return redirect('admin/page/index')->withErrors(['success'=>'添加成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'添加失败']);
            }
        }
        return view('admin.page.create');
    }

    // 查看
    public function show(Request $request)
    {
        $page = Page::find($request->input('id'));
        if (!$page) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }
        return view('admin.page.show',['page'=>$page]);
    }

    // 修改
    public function update(Request $request)
    {
        // 基本信息
        $page = Page::find($request->input('id'));
        if (!$page) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }

        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'id'=>'required|integer',
                'title'=>'required|string|between:1,255',
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
                'order'=>'required|integer',
            ], [], [
                'id'=>'ID',
                'title'=>'标题',
                'keywords'=>'关键词',
                'description'=>'描述',
                'content'=>'内容',
                'status'=>'状态',
                'order'=>'排序',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 获取数据
            $data = $request->only(['title','keywords','description','content','status','order']);

            // 入库
            $page = Page::edit($request->input('id'),$data);
            if ($page) {
                return redirect('admin/page/index')->withErrors(['success'=>'修改成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'修改失败']);
            }
        }
        return view('admin.page.update',['page'=>$page]);
    }

    // 删除
    public function delete(Request $request)
    {
        $page = Page::del($request->input('id'));
        if ($page) {
            return back()->withInput()->withErrors(['success'=>'删除成功']);
        } else {
            return back()->withInput()->withErrors(['error'=>'删除失败']);
        }
    }

    // 排序
    public function order(Request $request)
    {
        // POST请求
        if ($request->isMethod('post')) {
            $order = $request->input('order');
            Page::order($order);
        }
        return back()->withInput()->withErrors(['success'=>'排序成功']);
    }
}
