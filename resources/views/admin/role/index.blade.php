@extends('admin.layouts.app')

@section('title', '后台管理')

@section('head')
    <style>
        .laravel-page .pagination {margin:0;}
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
                    <li class=""><a href="javascript:void(0)">用户管理</a></li>
                    <li class="active"><a href="{{ url('admin/role/index') }}">角色管理</a></li>
                </ul><!-- /.breadcrumb -->
            </div>

            <div class="page-content">
                <div class="page-header">
                    <small>
                        (共{{ $list->total() }}条数据)
                    </small>
                    <div class="pull-right">
                        <a class="btn btn-sm btn-primary" title="刷新" onclick="location.reload()"><i class="fa fa-refresh"></i><span class="hidden-xs"> 刷新</span></a>
                        <a href="{{ url('admin/role/create') }}" class="btn btn-sm btn-success" title="添加"><i class="fa fa-plus"></i><span class="hidden-xs"> 添加</span></a>
                    </div>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                            <div class="col-xs-12" style="overflow: auto;">
                                <table id="simple-table" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>名称</th>
                                        <th>状态</th>
                                        <th>备注</th>
                                        <th>创建时间</th>
                                        <th>修改时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if (count($list) > 0)
                                        @foreach ($list as $key=>$value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->status_text }}</td>
                                                <td>{{ str_limit($value->remark,30) }}</td>
                                                <td>{{ $value->created_at }}</td>
                                                <td>{{ $value->updated_at }}</td>
                                                <td>
                                                    <a href="{{ url('admin/role/show') }}?id={{ $value->id }}" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                                                    <a href="{{ url('admin/role/update') }}?id={{ $value->id }}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                                                    <a href="javascript:void(0)" onclick="confirm('确认删除？')? location.href='{{ url('admin/role/delete') }}?id={{ $value->id }}': ''" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" align="center">暂无数据</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div><!-- /.span -->
                            <div class="col-xs-12 laravel-page">
                                {{ $list->render() }}
                            </div>
                        </div><!-- /.row -->
                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->
@endsection

@section('bottom')
@endsection
