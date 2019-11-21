@extends('admin.layouts.app')

@section('title', '后台管理')

@section('head')
    <script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/ueditor.config.js') }}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/ueditor.all.min.js') }}"> </script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/lang/zh-cn/zh-cn.js') }}"></script>
    <style>
        #content {width: 1024px;height:500px;}
    </style>
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
                    <li class="">内容管理</li>
                    <li class="active">页面管理</li>
                </ul><!-- /.breadcrumb -->
            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            页面查看
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
                                    <input type="text" name="title" value="{{ $page->title }}" placeholder="标题" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 关键词 </label>

                                <div class="col-sm-9">
                                    <textarea name="keywords" rows="3" class="col-xs-10 col-sm-5" placeholder="关键词">{{ $page->keywords }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 描述 </label>

                                <div class="col-sm-9">
                                    <textarea name="description" rows="3" class="col-xs-10 col-sm-5" placeholder="描述">{{ $page->description }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> *内容 </label>

                                <div class="col-sm-9" style="overflow: auto;">
                                    <script id="content" name="content" type="text/plain">{!! $page->content !!}</script>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 状态 </label>

                                <div class="col-sm-9">
                                    <input type="text" name="status" value="{{ $page->status_text }}" placeholder="" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> *排序 </label>

                                <div class="col-sm-9">
                                    <input type="number" name="order" value="{{ $page->order }}" placeholder="排序" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="clearfix form-actions" style="display: none;">
                                <div class="col-md-offset-3 col-md-9">
                                    <input type="submit" class="btn btn-info" value="提交" onclick="if(!hasContent()){alert('内容不能为空');return false;}">
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
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('content');
        function hasContent() {
            return UE.getEditor('content').hasContents();
        }
        $(function () {
            // 禁止可输入元素
            $('input,textarea,select').attr('disabled','disabled');
        })
    </script>
@endsection
