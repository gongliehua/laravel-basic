@extends('index.layouts.app')

@section('keywords','')
@section('description','')
@section('title',\App\Libraries\Config::getInstance()->get('name').' - '.\App\Libraries\Config::getInstance()->get('archives','Archives'))

@section('content')
    <div id="content">
        <div id="primary">
            <section id="archive" class="archive">
                @if (count($list))
                    @foreach($list as $value)
                        @if (!isset($year))
                            <?php $year = date('Y',strtotime($value->created_at)); ?>
                            <div class="collection-title">
                                <h2 class="archive-year">{{ $year }}</h2>
                            </div>
                        @else
                            @if ($year != date('Y',strtotime($value->created_at)))
                                <?php $year = date('Y',strtotime($value->created_at)); ?>
                                <div class="collection-title">
                                    <h2 class="archive-year">{{ $year }}</h2>
                                </div>
                            @endif
                        @endif
                        <?php $year = date('Y',strtotime($value->created_at)); ?>
                        <div class="archive-post">
                            <span class="archive-post-time">{{ date('M d',strtotime($value->created_at)) }}</span>
                            <span class="archive-post-title">
                                @if (\App\Libraries\Config::getInstance()->get('aliasArticle','是') == '是')
                                    @if (strlen($value->alias))
                                        <a href="/archives/{{ $value->alias }}.html" class="archive-post-link">{{ $value->title }}</a>
                                    @else
                                        <a href="/archives/{{ $value->id }}.html" class="archive-post-link">{{ $value->title }}</a>
                                    @endif
                                @else
                                    <a href="/archives/{{ $value->id }}.html" class="archive-post-link">{{ $value->title }}</a>
                                @endif
                            </span>
                        </div>
                    @endforeach
                @else
                    <div class="collection-title">
                        <h2 class="archive-year">{{ date('Y') }}</h2>
                    </div>
                    <div class="archive-post">
                        <span class="archive-post-time">{{ date('M d') }}</span>
                        <span class="archive-post-title">
                        <a href="javascript:void(0)" class="archive-post-link">暂无数据</a>
                    </span>
                    </div>
                @endif
            </section>
        </div>
        <nav class="pagination">
            @if ($list->previousPageUrl())
                <a class="prev" href="{{ $list->previousPageUrl() }}"><i class="iconfont icon-left"></i><span class="prev-text">Prev</span></a>
            @endif
            @if ($list->nextPageUrl())
                <a class="next" href="{{ $list->nextPageUrl() }}"><span class="next-text">Next</span><i class="iconfont icon-right"></i></a>
            @endif
        </nav>
    </div>
@endsection
