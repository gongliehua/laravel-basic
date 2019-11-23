<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,minimum-scale=1,maximum-scale=1">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="@yield('description')">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=92230095"></script>
    <title>@yield('title')</title>
    <script type="text/javascript">
        var themeConfig = {
            fancybox: {
                enable: false
            },
        };
    </script>
</head>
<body>
<div id="page">
    <header id="masthead">
        <div class="site-header-inner">
            <h1 class="site-title">
                <a href="{{ \App\Libraries\Config::getInstance()->get('site','/') }}" class="logo">{{ \App\Libraries\Config::getInstance()->get('name','Hello World') }}</a>
            </h1>
            <nav id="nav-top">
                <ul id="menu-top" class="nav-top-items">
                    <li class="menu-item"><a href="/archives">{{ \App\Libraries\Config::getInstance()->get('archives','Archives') }}</a></li>
                    @foreach(\App\Models\Page::frontendRender() as $value)
                        @if (\App\Libraries\Config::getInstance()->get('aliasPage','否') == '是')
                            @if (strlen($value->alias))
                                <li class="menu-item"><a href="/{{ $value->alias }}.html">{{ $value->title }}</a></li>
                            @else
                                <li class="menu-item"><a href="/{{ $value->id }}.html">{{ $value->title }}</a></li>
                            @endif
                        @else
                            <li class="menu-item"><a href="/{{ $value->id }}.html">{{ $value->title }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </nav>
        </div>
    </header>

    @yield('content')

    <footer id="colophon">
        {!! \App\Libraries\Config::getInstance()->get('copyright','&copy; 2019') !!}
    </footer>

    <div class="back-to-top" id="back-to-top">
        <i class="iconfont icon-up"></i>
    </div>
</div>

<script type="text/javascript" src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/theme.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>

</body>
</html>
