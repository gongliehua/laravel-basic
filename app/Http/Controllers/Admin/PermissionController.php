<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

// 权限控制器
class PermissionController extends BaseController
{
    // 列表
    public function index(Request $request)
    {
        // 分页参数
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',15);
        $offset = ($page - 1) * $pageSize;

        // 查找所有数据排序后再分页显示
        $list= $this->toTwoArray(Permission::orderBy('order','asc')->get());
        $this->toTwoArray([], 0, 0, true);
        $list = new LengthAwarePaginator(array_slice($list,$offset,$pageSize),count($list),$pageSize,$page,['path'=>$request->url(),'query'=>$request->query()]);

        return view('admin.permission.index',['list'=>$list]);
    }

    // 添加
    public function create(Request $request)
    {
        //
        return view('admin.permission.create');
    }

    // 查看
    public function show(Request $request)
    {
        //
    }

    // 修改
    public function update(Request $request)
    {
        //
    }

    // 排序
    public function order(Request $request)
    {
        // POST请求
        if ($request->isMethod('post')) {
            $order = $request->input('order');
            Permission::order($order);
        }
        return back()->withInput()->withErrors(['success'=>'排序成功']);
    }
}
