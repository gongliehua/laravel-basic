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
                        <a href="{{ url('admin/index') }}">主页</a>
                    </li>
                    <li class=""><a href="javascript:void(0)">内容管理</a></li>
                    <li class="active"><a href="{{ url('admin/article/index') }}">文章管理</a></li>
                </ul><!-- /.breadcrumb -->
            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            文章修改
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
                                    <input type="text" name="title" value="{{ old('title') ? old('title') : $article->title }}" placeholder="标题" class="col-xs-10 col-sm-5" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 作者 </label>
                                <div class="col-sm-9">
                                    <input type="text" name="author" value="{{ old('author') ? old('author') : $article->author }}" placeholder="作者" class="col-xs-10 col-sm-5" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 关键词 </label>

                                <div class="col-sm-9">
                                    <textarea name="keywords" rows="3" class="col-xs-10 col-sm-5" placeholder="关键词">{{ old('keywords') ? old('keywords') : $article->keywords }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 描述 </label>

                                <div class="col-sm-9">
                                    <textarea name="description" rows="3" class="col-xs-10 col-sm-5" placeholder="描述">{{ old('description') ? old('description') : $article->description }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> *内容 </label>

                                <div class="col-sm-9" style="overflow: auto;">
                                    <script id="content" name="content" type="text/plain">{!! old('content') ? old('content') : $article->content !!}</script>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> 状态 </label>

                                <div class="col-sm-9">
                                    <select name="status" class="col-xs-10 col-sm-5">
                                        @foreach((new \App\Models\Page())->statusLabel as $key=>$value)
                                            @if (is_null(old('status')))
                                                <option value="{{ $key }}" @if($key == $article->status) selected @endif>{{ $value }}</option>
                                            @else
                                                <option value="{{ $key }}" @if($key == old('status')) selected @endif>{{ $value }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">标签</label>
                                <div class="col-sm-9">
                                    @if (count($tags) > 0)
                                        @foreach ($tags as $key=>$value)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="tag_id[]" value="{{ $value['id'] }}" @if (in_array($value['id'],$inIds)) checked @endif>{{ $value['name'] }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="checkbox"><label><input type="checkbox">暂无标签</label></div>
                                    @endif
                                </div>
                            </div>

                            <div class="clearfix form-actions">
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
    </script>
@endsection
