<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// 配置控制器
class ConfigController extends BaseController
{
    // 列表
    public function index(Request $request)
    {
        $list = Config::search($request);
        return view('admin.config.index',['list'=>$list]);
    }

    // 添加
    public function create(Request $request)
    {
        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title'=>'required|string|between:1,255',
                'variable'=>[
                    'required',
                    'string',
                    'alpha',
                    'between:1,255',
                    Rule::unique('configs')->where(function($query){
                        $query->whereNull('deleted_at');
                    }),
                ],
                'type'=>'required|integer',
                'order'=>'required|integer',
            ], [], [
                'title'=>'标题',
                'variable'=>'变量名',
                'type'=>'类型',
                'order'=>'排序',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 获取数据
            $data = $request->only(['title','variable','type','item','value','order']);

            // 入库
            $config = Config::add($data);
            if ($config !== false) {
                return redirect('admin/config/index')->withErrors(['success'=>'添加成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'添加失败']);
            }
        }
        return view('admin.config.create');
    }

    // 查看
    public function show(Request $request)
    {
        $config = Config::find($request->input('id'));
        if (!$config) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }
        return view('admin.config.show',['config'=>$config]);
    }

    // 修改
    public function update(Request $request)
    {
        // 基本信息
        $config = Config::find($request->input('id'));
        if (!$config) {
            return back()->withInput()->withErrors(['error'=>'未检索到该信息，请刷新页面后重试！']);
        }

        // POST请求
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'id'=>'required|integer',
                'title'=>'required|string|between:1,255',
                'variable'=>[
                    'required',
                    'string',
                    'alpha',
                    'between:1,255',
                    Rule::unique('configs')->where(function($query) use ($request){
                       $query->whereNull('deleted_at')->where('id','<>',$request->input('id'));
                    }),
                ],
                'type'=>'required|integer',
                'order'=>'required|integer',
            ], [], [
                'id'=>'ID',
                'title'=>'标题',
                'variable'=>'变量名',
                'type'=>'类型',
                'order'=>'排序',
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors(['error'=>$validator->errors()->first()]);
            }

            // 获取数据
            $data = $request->only(['title','variable','type','item','value','order']);

            // 入库
            $config = Config::edit($request->input('id'),$data);
            if ($config) {
                return redirect('admin/config/index')->withErrors(['success'=>'修改成功']);
            } else {
                return back()->withInput()->withErrors(['error'=>'修改失败']);
            }
        }
        return view('admin.config.update',['config'=>$config]);
    }

    // 删除
    public function delete(Request $request)
    {
        $config = Config::del($request->input('id'));
        if ($config) {
            return back()->withInput()->withErrors(['success'=>'删除成功']);
        } else {
            return back()->withInput()->withErrors(['error'=>'删除失败，请刷新页面后重试！']);
        }
    }

    // 排序
    public function order(Request $request)
    {
        // POST请求
        if ($request->isMethod('post')) {
            $order = $request->input('order');
            Config::order($order);
        }
        return back()->withInput()->withErrors(['success'=>'排序成功']);
    }

    // 设置
    public function setting(Request $request)
    {
        // POST请求
        if ($request->isMethod('post')) {
            $data = $request->input('value');
            Config::setting($data);
            return back()->withInput()->withErrors(['success'=>'修改成功']);
        }

        $list = Config::search($request);
        return view('admin.config.setting',['list'=>$list]);
    }
}
