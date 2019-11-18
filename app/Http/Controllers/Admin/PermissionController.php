<?php

namespace App\Http\Controllers\Admin;

use App\Libraries\Tools;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

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
        $tools = Tools::getInstance();
        $list= $tools->toTwoArray(Permission::orderBy('order','asc')->get());
        $tools->toTwoArray([], 0, 0, true);
        $list = new LengthAwarePaginator(array_slice($list,$offset,$pageSize),count($list),$pageSize,$page,['path'=>$request->url(),'query'=>$request->query()]);

        return view('admin.permission.index',['list'=>$list]);
    }

    // 添加
    public function create(Request $request)
    {
        $tools = Tools::getInstance();

        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title'=>'required|string|between:1,255',
                'is_menu'=>'required|integer',
                'status'=>'required|integer',
                'parent_id'=>[
                    'required',
                    function($attribute,$value,$fail) {
                        if ($value != 0) {
                            $permission = Permission::where('id',$value)->value('id');
                            if (!$permission) {
                                return $fail('上级权限不存在，请刷新页面后重试！');
                            }
                        }
                    },
                ],
            ], [], [
                'title'=>'标题',
                'is_menu'=>'菜单栏',
                'status'=>'状态',
                'parent_id'=>'上级权限',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 入库
            if ($permission = Permission::add($request->all())) {
                return redirect('admin/permission/index')->withErrors(['success'=>'添加成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'添加失败']);
            }
        }

        return view('admin.permission.create', ['permissions'=>$tools->allPermission()]);
    }

    // 查看
    public function show(Request $request)
    {
        $permission = Permission::with(['permission'])->find($request->input('id'));
        if (!$permission) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }
        return view('admin.permission.show', ['permission'=>$permission]);
    }

    // 修改
    public function update(Request $request)
    {
        // 基本信息
        $permission = Permission::with(['permission'])->find($request->input('id'));
        if (!$permission) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }
        // 获取所有权限 及 获取上级权限不能是子级权限的数组
        $tools = Tools::getInstance();
        $permissions = $tools->allPermission(); //所有权限
        $notInIds = $tools->toTwoArray($permissions, $request->input('id')); //获取当前权限下的所有子权限(上级权限不能是子权限)
        $tools->toTwoArray([], 0, 0, true);
        $notInIds = array_column($notInIds, 'id');
        array_push($notInIds, $request->input('id')); // 把自己也加入数组中(上级权限不能是自己)

        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'id'=>[
                    'required',
                    function($attribute,$value,$fail){
                        $permission = Permission::where('id',$value)->value('id');
                        if (!$permission) {
                            return $fail('未检索到该信息，请刷新页面后重试！');
                        }
                    },
                ],
                'title'=>'required|between:1,255',
                'is_menu'=>'required|integer',
                'status'=>'required|integer',
                'parent_id'=>[
                    'required',
                    function($attribute,$value,$fail) {
                        if ($value != 0) {
                            $permission = Permission::where('id',$value)->value('id');
                            if (!$permission) {
                                return $fail('上级权限不存在，请刷新页面后重试！');
                            }
                        }
                    },
                ],
            ], [], [
                'title'=>'标题',
                'is_menu'=>'菜单栏',
                'status'=>'状态',
                'parent_id'=>'上级权限',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 更新
            $permission = Permission::edit([['id','=',$request->input('id')]], $request->only(['parent_id','icon','title','path','is_menu','status','order','remark']));
            if ($permission) {
                return redirect('admin/permission/index')->withErrors(['success'=>'修改成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'修改失败']);
            }
        }

        return view('admin.permission.update', ['permission'=>$permission,'permissions'=>$permissions,'notInIds'=>$notInIds]);
    }

    // 删除
    public function delete(Request $request)
    {
        $permission = Permission::del($request->input('id'));
        if ($permission === true) {
            return back()->withInput()->withErrors(['success'=>'删除成功']);
        } else {
            return back()->withInput()->withErrors(['error'=>$permission]);
        }
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
