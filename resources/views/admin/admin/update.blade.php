@extends('admin.layouts.app')

@section('title', '后台管理')

@section('head')
@endsection

@section('content')
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        主页
                    </li>
                    <li class="">用户管理</li>
                    <li class="active">管理员管理</li>
                </ul><!-- /.breadcrumb -->
            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            管理员修改
                        </small>
                    </h1>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> *用户名 </label>
                                <div class="col-sm-9">
                                    <input type="text" name="username" value="{{ old('username') ? old('username') : $admin->username }}" placeholder="用户名" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 密码 </label>

                                <div class="col-sm-9">
                                    <input type="password" name="password" value="{{ old('password') ? old('password') : '' }}" placeholder="123456" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 确认密码 </label>

                                <div class="col-sm-9">
                                    <input type="password" name="password_confirmation" value="{{ old('password_confirmation') ? old('password_confirmation') : '' }}" placeholder="123456" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 角色 </label>

                                <div class="col-sm-9">
                                    <select name="role_id" class="col-xs-10 col-sm-5">
                                        @foreach($roles as $key=>$value)
                                            @if (is_null(old('role_id')))
                                                <option value="{{ $value->id }}" @if($value->id == @$admin->adminRoleOne->role->id) selected @endif>{{ $value->name }}</option>
                                            @else
                                                <option value="{{ $value->id }}" @if($value->id == old('role_id')) selected @endif>{{ $value->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> *昵称 </label>

                                <div class="col-sm-9">
                                    <input type="text" name="name" value="{{ old('name') ? old('name') : $admin->name }}" placeholder="昵称" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 性别 </label>

                                <div class="col-sm-9">
                                    <select name="sex" class="col-xs-10 col-sm-5">
                                        @foreach((new \App\Models\Admin())->sexLabel as $key=>$value)
                                            @if (is_null(old('sex')))
                                                <option value="{{ $key }}" @if($admin->sex == $key) selected @endif>{{ $value }}</option>
                                            @else
                                                <option value="{{ $key }}" @if(old('sex') == $key) selected @endif>{{ $value }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 头像 </label>

                                <div class="col-sm-9">
                                    <input type="file" name="avatar" id="avatar" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 状态 </label>

                                <div class="col-sm-9">
                                    <select name="status" class="col-xs-10 col-sm-5">
                                        @foreach((new \App\Models\Admin())->statusLabel as $key=>$value)
                                            @if (is_null(old('status')))
                                                <option value="{{ $key }}" @if($key == $admin->status) selected @endif>{{ $value }}</option>
                                            @else
                                                <option value="{{ $key }}" @if($key == old('status')) selected @endif>{{ $value }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <input type="submit" class="btn btn-info" value="提交">
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="reset" class="btn" value="重置">
                                </div>
                            </div>
                            <hr>
                        </form>
                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->
@endsection

@section('bottom')
@endsection
