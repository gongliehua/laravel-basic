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
                        <a href="{{ url('admin/index') }}">主页</a>
                    </li>
                    <li class=""><a href="javascript:void(0)">用户管理</a></li>
                    <li class="active"><a href="{{ url('admin/admin/index') }}">管理员管理</a></li>
                </ul><!-- /.breadcrumb -->
            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            管理员查看
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
                                    <input type="text" name="username" value="{{ $admin->username }}" placeholder="用户名" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 角色 </label>

                                <div class="col-sm-9">
                                    <input type="text" name="role_id" value="{{ @$admin->adminRoleOne->role->name }}" placeholder="" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> *昵称 </label>

                                <div class="col-sm-9">
                                    <input type="text" name="name" value="{{ $admin->name }}" placeholder="昵称" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 性别 </label>

                                <div class="col-sm-9">
                                    <input type="text" name="sex" value="{{ $admin->sex_text }}" placeholder="" class="col-xs-10 col-sm-5" required />
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
                                    <input type="text" name="status" value="{{ $admin->status_text }}" placeholder="" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="clearfix form-actions" style="display: none;">
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
    <script>
        $(function () {
            // 禁止可输入元素
            $('input,textarea,select').attr('disabled','disabled');
        })
    </script>
@endsection
