<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// 标签控制器
class TagController extends BaseController
{
    // 列表
    public function index(Request $request)
    {
        $list = Tag::search($request);
        return view('admin.tag.index',['list'=>$list]);
    }

    // 添加
    public function create(Request $request)
    {
        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name'=>'required|string|between:1,255',
                'order'=>'required|integer',
            ], [], [
                'name'=>'名称',
                'order'=>'排序',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 获取数据
            $data = $request->only(['name','order']);

            // 入库
            $tag = Tag::add($data);
            if ($tag) {
                return redirect('admin/tag/index')->withErrors(['success'=>'添加成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'添加失败']);
            }
        }
        return view('admin.tag.create');
    }

    // 查看
    public function show(Request $request)
    {
        $tag = Tag::find($request->input('id'));
        if (!$tag) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }
        return view('admin.tag.show',['tag'=>$tag]);
    }

    // 修改
    public function update(Request $request)
    {
        // 基本信息
        $tag = Tag::find($request->input('id'));
        if (!$tag) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }

        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'id'=>'required|integer',
                'name'=>'required|string|between:1,255',
                'order'=>'required|integer',
            ], [], [
                'id'=>'ID',
                'name'=>'名称',
                'order'=>'排序',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 获取数据
            $data = $request->only(['name','order']);

            // 入库
            $tag = Tag::edit($request->input('id'),$data);
            if ($tag) {
                return redirect('admin/tag/index')->withErrors(['success'=>'修改成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'修改失败']);
            }
        }
        return view('admin.tag.update',['tag'=>$tag]);
    }

    // 删除
    public function delete(Request $request)
    {
        $tag = Tag::del($request->input('id'));
        if ($tag === true) {
            return back()->withInput()->withErrors(['success'=>'删除成功']);
        } else {
            return back()->withInput()->withErrors(['error'=>$tag]);
        }
    }

    // 排序
    public function order(Request $request)
    {
        // POST请求
        if ($request->isMethod('post')) {
            $order = $request->input('order');
            Tag::order($order);
        }
        return back()->withInput()->withErrors(['success'=>'排序成功']);
    }
}
