<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// 基本控制器
class IndexController extends BaseController
{
    // 后台首页
    public function index(Request $request)
    {
        return view('admin.index');
    }

    // 个人信息
    public function profile(Request $request)
    {
        return view('admin.profile');
    }

    // 后台登录
    public function login(Request $request)
    {
        // POST请求
        if ($request->isMethod('post')) {
            // 表单验证
            $validator = Validator::make($request->all(), [
                'username'=>'required',
                'password'=>'required',
            ], [], [
                'username'=>'用户名',
                'password'=>'密码',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            }

            // 验证用户名和密码
            $admin = Admin::verifyUserNamePassword($request->input('username'), $request->input('password'));
            if (is_object($admin)) {
                Auth::guard('admin')->login($admin, $request->has('remember'));
                return redirect('admin/index');
            } else {
                return back()->withInput()->withErrors(['username'=>$admin]);
            }
        }
        return view('admin.login');
    }

    // 退出登录
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
