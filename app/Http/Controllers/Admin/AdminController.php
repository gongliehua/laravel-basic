<?php

namespace App\Http\Controllers\Admin;

use App\Libraries\Tools;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// 管理员控制器
class AdminController extends BaseController
{
    // 列表
    public function index(Request $request)
    {
        $result = Admin::search($request);

        return view('admin.admin.index', ['list'=>$result]);
    }

    // 添加
    public function create(Request $request)
    {
        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'username'=>'required|string|alpha_dash|between:3,32|unique:admins,username',
                'password'=>[
                    'confirmed',
                    function ($attribute,$value,$fail) use($request) {
                        // 判断长度及内容
                        if (strlen($value)) {
                            $validPassword = Validator::make($request->all(), [
                                'password'=>'alpha_dash|string|between:6,18'
                            ], [], [
                                'password'=>'密码'
                            ]);
                            if ($validPassword->fails()) {
                                return $fail($validPassword->errors()->first());
                            }
                        }
                    },
                ],
                'role_id'=>[
                    'required',
                    function($attribute,$value,$fail){
                        $role = Role::where('id',$value)->value('id');
                        if (!$role) {
                            return $fail('该角色未检索到，请刷新页面后重试！');
                        }
                    }
                ],
                'name'=>'required|string|between:3,32',
                'sex'=>'required|integer',
                'status'=>'required|integer',
            ], [], [
                'username'=>'用户名',
                'password'=>'密码',
                'role_id'=>'角色',
                'name'=>'昵称',
                'status'=>'昵称',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 数据组装
            $data = $request->only(['username','role_id','name','sex','status']);
            // 密码处理
            if (strlen($request->input('password'))) {
                $data['password'] = sha1($request->input('password'));
            } else {
                $data['password'] = sha1('123456');
            }
            // 头像处理
            if ($avatar = $request->file('avatar')) {
                $avatar = Tools::getInstance()->fileUpload($avatar,'uploads/avatar',['php']);
                if ($avatar['code'] !== 0) {
                    return back()->withInput()->withErrors(['error'=>$avatar['msg']]);
                }
                $data['avatar'] = $avatar['data'];
            }

            // 入库
            $admin = Admin::add($data);
            if ($admin) {
                return redirect('admin/admin/index')->withErrors(['success'=>'添加成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'添加失败']);
            }
        }

        // 所有角色
        $roles = Role::all();
        return view('admin.admin.create',['roles'=>$roles]);
    }

    // 查看
    public function show(Request $request)
    {
        $admin = Admin::with(['adminRoleOne'=>function($query){
            $query->with('role');
        }])->find($request->input('id'));
        if (!$admin) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }
        return view('admin.admin.show',['admin'=>$admin]);
    }

    // 修改
    public function update(Request $request)
    {
        // 基本信息
        $admin = Admin::with(['adminRoleOne'=>function($query){
            $query->with('role');
        }])->find($request->input('id'));
        if (!$admin) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }

        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'id'=>'required',
                //'username'=>'required|string|alpha_dash|between:3,32|unique:admins,username,'.$request->input('id').',id',
                'password'=>[
                    'confirmed',
                    function ($attribute,$value,$fail) use($request) {
                        // 判断长度及内容
                        if (strlen($value)) {
                            $validPassword = Validator::make($request->all(), [
                                'password'=>'alpha_dash|string|between:6,18'
                            ], [], [
                                'password'=>'密码'
                            ]);
                            if ($validPassword->fails()) {
                                return $fail($validPassword->errors()->first());
                            }
                        }
                    },
                ],
                'role_id'=>[
                    'required',
                    function($attribute,$value,$fail){
                        $role = Role::where('id',$value)->value('id');
                        if (!$role) {
                            return $fail('该角色未检索到，请刷新页面后重试！');
                        }
                    }
                ],
                'name'=>'required|string|between:3,32',
                'sex'=>'required|integer',
                'status'=>'required|integer',
            ], [], [
                'id'=>'ID',
                'username'=>'用户名',
                'password'=>'密码',
                'role_id'=>'角色',
                'name'=>'昵称',
                'status'=>'昵称',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 数据组装
            $data = $request->only(['name','sex','status']);
            // 密码处理
            if (strlen($request->input('password'))) {
                $data['password'] = sha1($request->input('password'));
            } else {
                $data['password'] = sha1('123456');
            }
            // 头像处理
            if ($avatar = $request->file('avatar')) {
                $avatar = Tools::getInstance()->fileUpload($avatar,'uploads/avatar',['php']);
                if ($avatar['code'] !== 0) {
                    return back()->withInput()->withErrors(['error'=>$avatar['msg']]);
                }
                $data['avatar'] = $avatar['data'];
            }

            // 入库
            $admin = Admin::editInfo($request->input('id'),$data,$request->input('role_id'));
            if ($admin) {
                return redirect('admin/admin/index')->withErrors(['success'=>'修改成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'修改失败']);
            }
        }

        // 所有角色
        $roles = Role::all();
        return view('admin.admin.update',['admin'=>$admin,'roles'=>$roles]);
    }

    // 删除
    public function delete(Request $request)
    {
        $admin = Admin::del($request->input('id'));
        if ($admin) {
            return redirect('admin/admin/index')->withErrors(['success'=>'删除成功']);
        } else {
            return back()->withErrors(['error'=>'删除失败']);
        }
    }
}
