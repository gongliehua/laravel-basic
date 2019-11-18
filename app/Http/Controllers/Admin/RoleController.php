<?php

namespace App\Http\Controllers\Admin;

use App\Libraries\Tools;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// 角色控制器
class RoleController extends BaseController
{
    // 列表
    public function index(Request $request)
    {
        $list = Role::search($request);

        return view('admin.role.index',['list'=>$list]);
    }

    // 添加
    public function create(Request $request)
    {
        $tools = Tools::getInstance();

        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name'=>'required|string|between:1,32',
                'status'=>'required|integer',
            ], [], [
                'title'=>'名称',
                'status'=>'状态',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 入库
            if (($role = Role::add($request->all())) === true) {
                return redirect('admin/role/index')->withErrors(['success'=>'添加成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>$role]);
            }
        }

        return view('admin.role.create', ['permissions'=>$tools->allPermission()]);
    }

    // 查看
    public function show(Request $request)
    {
        // 基本信息
        $role = Role::find($request->input('id'));
        if (!$role) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }
        // 拥有的权限ID
        $inIds = RolePermission::where('role_id',$request->input('id'))->pluck('permission_id');
        $inIds = json_decode(json_encode($inIds),true);
        // 获取所有权限
        $permissions = Tools::getInstance()->allPermission();

        return view('admin.role.show', ['role'=>$role,'permissions'=>$permissions,'inIds'=>$inIds]);
    }

    // 修改
    public function update(Request $request)
    {
        // 基本信息
        $role = Role::find($request->input('id'));
        if (!$role) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }
        // 拥有的权限ID
        $inIds = RolePermission::where('role_id',$request->input('id'))->pluck('permission_id');
        $inIds = json_decode(json_encode($inIds),true);
        // 获取所有权限
        $permissions = Tools::getInstance()->allPermission();

        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'id'=>'required',
                'name'=>'required|string|between:1,32',
                'status'=>'required|integer',
            ], [], [
                'id'=>'ID',
                'title'=>'名称',
                'status'=>'状态',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 更新
            $role = Role::edit($request->input('id'), $request->only(['name','status','remark']), $request->input('permission_id'));
            if ($role) {
                return redirect('admin/role/index')->withErrors(['success'=>'修改成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'修改失败']);
            }
        }

        return view('admin.role.update', ['role'=>$role,'permissions'=>$permissions,'inIds'=>$inIds]);
    }

    // 删除
    public function delete(Request $request)
    {
        $role = Role::del($request->input('id'));
        if ($role === true) {
            return back()->withInput()->withErrors(['success'=>'删除成功']);
        } else {
            return back()->withInput()->withErrors(['error'=>$role]);
        }
    }
}
