@extends('index.layouts.app')

@section('keywords',$info['info']->keywords)
@section('description',$info['info']->description)
@section('title',\App\Libraries\Config::getInstance()->get('name').' - '.$info['info']->title)

@section('content')
    <div id="content">
        <div id="primary">
            <article class="post">
                <header class="post-header">
                    <h1 class="post-title">{{ $info['info']->title }}</h1>
                    <time class="post-time">{{ date('M d Y',strtotime($info['info']->created_at)) }}</time>
                </header>
                <div class="post-content">
                    {!! $info['info']->content !!}
                </div>
                <footer class="post-footer">
                    <div class="post-tags">
                        @foreach($info['info']->tag as $value)
                            <a href="javascript:void(0)">{{ $value->name }}</a>
                        @endforeach
                    </div>
                    <nav class="post-nav">
                        @if ($info['prev'])
                            @if (\App\Libraries\Config::getInstance()->get('aliasArticle','是') == '是')
                                @if (strlen($info['prev']->alias))
                                    <a class="prev" href="/archives/{{ $info['prev']->alias }}.html">
                                        <i class="iconfont icon-left"></i>
                                        <span class="prev-text nav-default">{{ str_limit($info['prev']->title) }}</span>
                                        <span class="prev-text nav-mobile">Next</span>
                                    </a>
                                @else
                                    <a class="prev" href="/archives/{{ $info['prev']->id }}.html">
                                        <i class="iconfont icon-left"></i>
                                        <span class="prev-text nav-default">{{ str_limit($info['prev']->title) }}</span>
                                        <span class="prev-text nav-mobile">Next</span>
                                    </a>
                                @endif
                            @else
                                <a class="prev" href="/archives/{{ $info['prev']->id }}.html">
                                    <i class="iconfont icon-left"></i>
                                    <span class="prev-text nav-default">{{ str_limit($info['prev']->title) }}</span>
                                    <span class="prev-text nav-mobile">Next</span>
                                </a>
                            @endif
                        @endif
                        @if ($info['next'])
                            @if (\App\Libraries\Config::getInstance()->get('aliasArticle','是') == '是')
                                @if (strlen($info['next']->alias))
                                    <a class="next" href="/archives/{{ $info['next']->alias }}.html">
                                        <span class="next-text nav-default">{{ str_limit($info['next']->title) }}</span>
                                        <span class="prev-text nav-mobile">Next</span>
                                        <i class="iconfont icon-right"></i>
                                    </a>
                                @else
                                    <a class="next" href="/archives/{{ $info['next']->id }}.html">
                                        <span class="next-text nav-default">{{ str_limit($info['next']->title) }}</span>
                                        <span class="prev-text nav-mobile">Next</span>
                                        <i class="iconfont icon-right"></i>
                                    </a>
                                @endif
                            @else
                                <a class="next" href="/archives/{{ $info['next']->id }}.html">
                                    <span class="next-text nav-default">{{ str_limit($info['next']->title) }}</span>
                                    <span class="prev-text nav-mobile">Next</span>
                                    <i class="iconfont icon-right"></i>
                                </a>
                            @endif
                        @endif
                    </nav>
                    <div class="comments" id="comments">
                        <div style="text-align:center;">
                            <button class="btn" id="load-disqus" onclick="return false;">评论已关闭</button>
                        </div>
                        <div id="disqus_thread">
                            <noscript>
                                Please enable JavaScript to view the
                                <a href="//disqus.com/?ref_noscript">comments powered by Disqus.</a>
                            </noscript>
                        </div>
                    </div>
                </footer>
            </article>
        </div>
    </div>
@endsection
