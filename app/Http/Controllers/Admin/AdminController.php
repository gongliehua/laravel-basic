<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;

// 管理员控制器
class AdminController extends BaseController
{
    // 列表
    public function index(Request $request)
    {
        $result = Admin::search($request);

        return view('admin.admin.index', ['list'=>$result]);
    }
}
