<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

// 权限控制器
class PermissionController extends BaseController
{
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
}
