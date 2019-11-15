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
        // POST请求
        if ($request->isMethod('post')) {
            // 表单验证
            $validator = Validator::make($request->all(), [
                'password'=>[
                    'confirmed',
                    function ($attribute,$value,$fail) use($request) {
                        // 判断长度及内容
                        if (strlen($value)) {
                            $validPassword = Validator::make($request->all(), [
                                'password'=>'alpha_dash|digits_between:6,18'
                            ], [], [
                                'password'=>'密码'
                            ]);
                            if ($validPassword->fails()) {
                                return $fail($validPassword->errors()->first());
                            }
                        }
                    }
                ],
                'name'=>'required|between:3,32',
                'sex'=>'required|integer',
            ], [], [
                'password'=>'密码',
                'name'=>'昵称',
                'sex'=>'性别',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }
            // 组装数据
            $data['name'] = $request->input('name');
            $data['sex'] = $request->input('sex');
            // 判断头像
            if ($avatar = $request->file('avatar')) {
                $avatar = $this->fileUpload($avatar,'uploads/avatar',['php']);
                if ($avatar['code'] !== 0) {
                    return back()->withInput()->withErrors(['error'=>$avatar['msg']]);
                }
                $data['avatar'] = $avatar['data'];
            }
            // 判断是否更改密码
            if (strlen($request->input('password'))) {
                $data['password'] = sha1($request->input('password'));
            }

            // 修改信息
            $admin = Admin::updateInfo([['id','=',Auth::guard('admin')->id()]], $data);
            if ($admin) {
                return back()->withErrors(['success'=>'修改成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'修改失败']);
            }
        }
        return view('admin.profile', ['admin'=>Auth::guard('admin')->user()]);
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
