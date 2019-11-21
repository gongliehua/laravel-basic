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
                    <li class="active"><a href="{{ url('admin/permission/index') }}">权限管理</a></li>
                </ul><!-- /.breadcrumb -->
            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            权限查看
                        </small>
                    </h1>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> *标题 </label>
                                <div class="col-sm-9">
                                    <input type="text" name="title" value="{{ $permission->title }}" placeholder="标题" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 图标 </label>

                                <div class="col-sm-9">
                                    <input type="text" name="icon" value="{{ $permission->icon }}" placeholder="图标" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> URL </label>

                                <div class="col-sm-9">
                                    <input type="text" name="path" value="{{ $permission->path }}" placeholder="URL" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 菜单栏 </label>

                                <div class="col-sm-9">
                                    <input type="text" name="is_menu" value="{{ $permission->is_menu_text }}" placeholder="" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 状态 </label>

                                <div class="col-sm-9">
                                    <input type="text" name="status" value="{{ $permission->status_text }}" placeholder="" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> *排序 </label>

                                <div class="col-sm-9">
                                    <input type="number" name="order" value="{{ $permission->order }}" placeholder="排序" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 备注 </label>

                                <div class="col-sm-9">
                                    <textarea name="remark" rows="3" class="col-xs-10 col-sm-5" placeholder="备注">{!! $permission->remark !!}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">上级权限</label>
                                <div class="col-sm-9">
                                    @if ($permission->parent_id == 0)
                                        <input type="text" name="parent_id" value="顶级权限" placeholder="" class="col-xs-10 col-sm-5" />
                                    @else
                                        <input type="text" name="parent_id" value="{{ @$permission->permission->title }}" placeholder="" class="col-xs-10 col-sm-5" />
                                    @endif
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
