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
                    <li class="active">权限列表</li>
                </ul><!-- /.breadcrumb -->
            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            权限添加
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
                                    <input type="text" name="title" value="{{ old('title') ? old('title') : '' }}" placeholder="标题" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 图标 </label>

                                <div class="col-sm-9">
                                    <input type="text" name="icon" value="{{ old('icon') ? old('icon') : 'fa-caret-right' }}" placeholder="图标" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> URL </label>

                                <div class="col-sm-9">
                                    <input type="text" name="path" value="{{ old('path') ? old('path') : '' }}" placeholder="URL" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 菜单栏 </label>

                                <div class="col-sm-9">
                                    <select name="is_menu" class="col-xs-10 col-sm-5">
                                        @foreach((new \App\Models\Permission())->is_menuLabel as $key=>$value)
                                            <option value="{{ $key }}" @if($key == old('is_menu')) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 状态 </label>

                                <div class="col-sm-9">
                                    <select name="status" class="col-xs-10 col-sm-5">
                                        @foreach((new \App\Models\Permission())->statusLabel as $key=>$value)
                                            <option value="{{ $key }}" @if($key == old('status')) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> *排序 </label>

                                <div class="col-sm-9">
                                    <input type="number" name="order" value="{{ old('order') ? old('order') : 100 }}" placeholder="排序" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 备注 </label>

                                <div class="col-sm-9">
                                    <textarea name="remark" rows="3" class="col-xs-10 col-sm-5" placeholder="备注">{{ old('order') ? old('order') : '' }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">上级权限</label>
                                <div class="col-sm-9">
                                    <select name="parent_id" class="col-xs-10 col-sm-5">
                                        <option value="0">｜顶级权限</option>
                                        @if (count($permissions = (new \App\Http\Controllers\Admin\BaseController())->allPermission()) > 0)
                                            @foreach ($permissions as $key=>$value)
                                                <option value="{{ $value->id }}"> @if ($value->parent_id == 0) ｜ @endif {{ str_repeat('－',$value->level*4) }} {{ $value->title }}</option>
                                            @endforeach
                                        @endif
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
