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
                        主页
                    </li>
                    <li class="">系统管理</li>
                    <li class="active">配置设定</li>
                </ul><!-- /.breadcrumb -->
            </div>

            <div class="page-content">
                <div class="page-header">
                    <small>
                        (共{{ $list->total() }}条数据)
                    </small>
                    <div class="pull-right">
                        <a class="btn btn-sm btn-primary" title="刷新" onclick="location.reload()"><i class="fa fa-refresh"></i><span class="hidden-xs"> 刷新</span></a>
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
                                        <th style="width: 100px;">变量名</th>
                                        <th style="width: 300px;">标题</th>
                                        <th>配置值</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if (count($list) > 0)
                                        <form action="{{ url('admin/config/setting') }}" method="post">
                                            @foreach ($list as $key=>$value)
                                                <tr>
                                                    <td>{{ $value->variable }}</td>
                                                    <td>{{ $value->title }}</td>
                                                    @if ($value->type == \App\Models\Config::TYPE_TEXT)
                                                        {{-- 单行文本框 --}}
                                                        <td><input type="text" name="value[{{ $value->id }}]" value="{{ $value->value }}" style="width: 400px;"></td>
                                                    @elseif ($value->type == \App\Models\Config::TYPE_TEXTAREA)
                                                        {{-- 多行文本框 --}}
                                                        <td><textarea name="value[{{ $value->id }}]" rows="3" style="width: 400px;">{{ $value->value }}</textarea></td>
                                                    @elseif ($value->type == \App\Models\Config::TYPE_RADIO)
                                                        {{-- 单选按钮 --}}
                                                        <td>
                                                            @if (strlen($value->item))
                                                                @foreach(($items = explode(',',$value->item)) as $val)
                                                                    <label><input type="radio" name="value[{{ $value->id }}]" value="{{ $val }}" @if ($val == $value->value) checked @endif> {{ $val }}</label>
                                                                    <br>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                    @elseif ($value->type == \App\Models\Config::TYPE_CHECKBOX)
                                                        {{-- 复选框 --}}
                                                        <td>
                                                            @if (strlen($value->item))
                                                                @if (strlen($value->value))
                                                                    <?php $values = explode(',',$value->value); ?>
                                                                @else
                                                                    <?php $values = []; ?>
                                                                @endif
                                                                @foreach(($items = explode(',',$value->item)) as $val)
                                                                    <label><input type="checkbox" name="value[{{ $value->id }}][]" value="{{ $val }}" @if (in_array($val,$values)) checked @endif> {{ $val }}</label>
                                                                    <br>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                    @elseif ($value->type == \App\Models\Config::TYPE_SELECT)
                                                        {{-- 下拉框 --}}
                                                        <td>
                                                            @if (strlen($value->item))
                                                                <select name="value[{{ $value->id }}]">
                                                                    @foreach(($items = explode(',',$value->item)) as $val)
                                                                        <option value="{{ $val }}" @if ($val == $value->value) selected @endif>{{ $val }}</option>
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td>&nbsp;</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            <tr>
                                                {{ csrf_field() }}
                                                <td colspan="3"><input type="submit" value="修改"></td>
                                            </tr>
                                        </form>
                                    @else
                                        <tr>
                                            <td colspan="3" align="center">暂无数据</td>
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
