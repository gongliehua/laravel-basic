@extends('index.layouts.app')

@section('keywords',\App\Libraries\Config::getInstance()->get('keywords'))
@section('description',\App\Libraries\Config::getInstance()->get('description'))
@section('title',\App\Libraries\Config::getInstance()->get('name'))

@section('content')
    <div id="content">
        <div id="primary" class="home">
            @if (count($articles))
                @foreach($articles as $value)
                    <article class="post">
                        <header class="post-header">
                            <h1 class="post-title">
                                @if (\App\Libraries\Config::getInstance()->get('aliasArticle','否') == '是')
                                    @if (strlen($value->alias))
                                        <a class="post-link" href="/archives/{{ $value->alias }}.html">{{ str_limit($value->title,20) }}</a>
                                    @else
                                        <a class="post-link" href="/archives/{{ $value->id }}.html">{{ str_limit($value->title,20) }}</a>
                                    @endif
                                @else
                                    <a class="post-link" href="/archives/{{ $value->id }}.html">{{ str_limit($value->title,20) }}</a>
                                @endif
                            </h1>
                            <time class="post-time">{{ date('M d Y',strtotime($value->created_at)) }}</time>
                        </header>
                        <div class="post-excerpt post-content">
                            <p>{!! str_limit(strip_tags($value->content),120) !!}</p>
                        </div>
                    </article>
                @endforeach
            @else
                <article class="post">
                    <header class="post-header">
                        <h1 class="post-title">
                            <a class="post-link" href="javascript:void(0)">Hello World</a>
                        </h1>
                        <time class="post-time">{{ date('M d Y') }}</time>
                    </header>
                    <div class="post-excerpt post-content">
                        <p>这已经是 最前/最后 一页了！</p>
                        <p>山中一夜饱雨，次晨醒来，在旭日未升的原始幽静中，冲着隔夜的寒气，踏着满地的断柯枝叶和仍在流泻的细股雨水，一径探入森林的秘密，曲曲弯弯，步上山去。—— 余光中《听听那冷雨》</p>
                    </div>
                </article>
            @endif
            <nav class="pagination">
                @if ($articles->previousPageUrl())
                    <a class="prev" href="{{ $articles->previousPageUrl() }}"><i class="iconfont icon-left"></i><span class="prev-text">Prev</span></a>
                @endif
                @if ($articles->nextPageUrl())
                    <a class="next" href="{{ $articles->nextPageUrl() }}"><span class="next-text">Next</span><i class="iconfont icon-right"></i></a>
                @endif
            </nav>
        </div>
        <div id="secondary">
            <section id="tags" class="widget-area widget_tags">
                <h3 class="widget-title">Tags</h3>
                <ul class="tag-list">
                    @if (count($tags))
                        @foreach($tags as $value)
                            <li class="tag-list-item">
                                <a class="tag-list-link" href="javascript:void(0)">{{ $value->name }}</a>
                                <span class="tag-list-count">@if ($value->article_count) {{ $value->article_count }} @endif</span></li>
                        @endforeach
                    @else
                        <li class="tag-list-item"><a class="tag-list-link" href="javascript:void(0)">暂无标签</a><span class="tag-list-count"></span></li>
                    @endif
                </ul>
            </section>
        </div>
    </div>
@endsection
