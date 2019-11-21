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
                    <li class="active"><a href="{{ url('admin/role/index') }}">角色管理</a></li>
                </ul><!-- /.breadcrumb -->
            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            角色添加
                        </small>
                    </h1>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> *名称 </label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" value="{{ old('name') ? old('name') : '' }}" placeholder="名称" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 状态 </label>

                                <div class="col-sm-9">
                                    <select name="status" class="col-xs-10 col-sm-5">
                                        @foreach((new \App\Models\Role())->statusLabel as $key=>$value)
                                            <option value="{{ $key }}" @if($key == old('status')) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 备注 </label>

                                <div class="col-sm-9">
                                    <textarea name="remark" rows="3" class="col-xs-10 col-sm-5" placeholder="备注">{{ old('remark') ? old('remark') : '' }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">权限</label>
                                <div class="col-sm-9">
                                    @if (count($permissions) > 0)
                                        @foreach ($permissions as $key=>$value)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permission_id[]" value="{{ $value['id'] }}" data-id="{{ $value['id'] }}" data-parentid="{{ $value['parent_id'] }}">@if ($value['parent_id'] === 0) ｜ @endif {{ str_repeat('－',$value['level']*4) }} {{ $value['title'] }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="checkbox"><label><input type="checkbox">暂无权限</label></div>
                                    @endif
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
    <script>
        $(function(){
            // 点击权限父级及子级也跟着选中
            $('input[type="checkbox"]').click(function(){
                if($(this).prop('checked')) {
                    $('input[data-parentid="'+$(this).attr('data-id')+'"]').prop('checked',true);
                    $('input[data-id="'+$(this).attr('data-parentid')+'"]').prop('checked',true);
                }
            });
        });
    </script>
@endsection
