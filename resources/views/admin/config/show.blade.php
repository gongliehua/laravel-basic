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
                    <li class=""><a href="javascript:void(0)">系统管理</a></li>
                    <li class="active"><a href="{{ url('admin/config/index') }}">配置管理</a></li>
                </ul><!-- /.breadcrumb -->
            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            配置查看
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
                                    <input type="text" name="title" value="{{ $config->title }}" placeholder="标题" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> *变量名 </label>
                                <div class="col-sm-9">
                                    <input type="text" name="variable" value="{{ $config->variable }}" placeholder="变量名" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 类型 </label>

                                <div class="col-sm-9">
                                    <input type="text" name="type" value="{{ $config->type_text }}" placeholder="类型" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 可选项 </label>

                                <div class="col-sm-9">
                                    <textarea name="item" rows="3" class="col-xs-10 col-sm-5" placeholder="可选项">{{ $config->item }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 配置值 </label>

                                <div class="col-sm-9">
                                    <textarea name="value" rows="3" class="col-xs-10 col-sm-5" placeholder="配置值">{{ $config->value }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> *排序 </label>

                                <div class="col-sm-9">
                                    <input type="number" name="order" value="{{ $config->order }}" placeholder="排序" class="col-xs-10 col-sm-5" />
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
