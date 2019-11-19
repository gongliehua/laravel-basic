<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>@yield('title', '后台管理')</title>

    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/font-awesome/4.5.0/css/font-awesome.min.css') }}" />

    <!-- page specific plugin styles -->

    <!-- text fonts -->
    <link rel="stylesheet" href="{{ url('assets/css/fonts.googleapis.com.css') }}" />

    <!-- toastr -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr-2.1.1/build/toastr.min.css') }}">

    <!-- ace styles -->
    <link rel="stylesheet" href="{{ url('assets/css/ace.min.css') }}" class="ace-main-stylesheet" id="main-ace-style" />

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ url('assets/css/ace-part2.min.css') }}" class="ace-main-stylesheet" />
    <![endif]-->
    <link rel="stylesheet" href="{{ url('assets/css/ace-skins.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/ace-rtl.min.css') }}" />

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ url('assets/css/ace-ie.min.css') }}" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
    <script src="{{ url('assets/js/ace-extra.min.js') }}"></script>

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <!--[if lte IE 8]>
    <script src="{{ url('assets/js/html5shiv.min.js') }}"></script>
    <script src="{{ url('assets/js/respond.min.js') }}"></script>
    <![endif]-->

    @yield('head')

    <script type="text/javascript">
        // 固定头部,导航栏
        if (localStorage.getItem('ace_state_id-navbar') == null) {
            localStorage.setItem('ace_state_id-navbar', '{"class":{"navbar-fixed-top":1}}');
            localStorage.setItem('ace_state_id-sidebar', '{"class":{"sidebar-fixed":1}}');
        }
    </script>
</head>

<body class="no-skin">
<div id="navbar" class="navbar navbar-default ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a href="{{ url('admin/index') }}" class="navbar-brand">
                <small>
                    <i class="fa fa-leaf"></i>
                    Ace Admin
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav" style="float:right!important;">
                <li class="blue dropdown-modal">
                    <a class="dropdown-toggle" href="{{ url('/') }}" target="_blank">
                        <i class="ace-icon fa fa-home"></i>
                    </a>
                </li>
                <li class="green dropdown-modal">
                    <a class="dropdown-toggle" href="javascript:location.reload();">
                        <i class="ace-icon fa fa-refresh"></i>
                    </a>
                </li>
                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="javascript:void(0);" class="dropdown-toggle">
                        @if (\Illuminate\Support\Facades\Auth::guard('admin')->user()->avatar)
                            <img class="nav-user-photo" src="{{ asset(\Illuminate\Support\Facades\Auth::guard('admin')->user()->avatar) }}" alt="Jason's Photo" />
                        @else
                            <img class="nav-user-photo" src="{{ asset('assets/images/avatars/user.jpg') }}" alt="Jason's Photo" />
                        @endif
                        <span class="user-info">
                            <small>欢迎,</small>
                            {{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->name }}
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="{{ url('admin/profile') }}">
                                <i class="ace-icon fa fa-user"></i>
                                个人信息
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="{{ url('admin/logout') }}">
                                <i class="ace-icon fa fa-power-off"></i>
                                退出
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.navbar-container -->
</div>

<div class="main-container ace-save-state" id="main-container">
    <script type="text/javascript">
        try{ace.settings.loadState('main-container')}catch(e){}
    </script>

    <div id="sidebar" class="sidebar responsive ace-save-state">
        <script type="text/javascript">
            try{ace.settings.loadState('sidebar')}catch(e){}
        </script>

        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                <button class="btn btn-success">
                    <i class="ace-icon fa fa-signal"></i>
                </button>

                <button class="btn btn-info">
                    <i class="ace-icon fa fa-pencil"></i>
                </button>

                <button class="btn btn-warning">
                    <i class="ace-icon fa fa-users"></i>
                </button>

                <button class="btn btn-danger">
                    <i class="ace-icon fa fa-cogs"></i>
                </button>
            </div>

            <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                <span class="btn btn-success"></span>

                <span class="btn btn-info"></span>

                <span class="btn btn-warning"></span>

                <span class="btn btn-danger"></span>
            </div>
        </div><!-- /.sidebar-shortcuts -->

        {!! \App\Libraries\Tools::getInstance()->buildMenu() !!}

        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
    </div>

    @yield('content')

    <div class="footer">
        <div class="footer-inner">
            <div class="footer-content">
                <span class="bigger-120">
                    &copy; 2019
                </span>
            </div>
        </div>
    </div>

    <a href="javascript:void(0);" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->
<script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="{{ asset('assets/js/jquery-1.11.3.min.js') }}"></script>
<![endif]-->

<!-- toastr -->
<script src="{{ asset('assets/plugins/toastr-2.1.1/build/toastr.min.js') }}"></script>

<script type="text/javascript">
    // 显示信息
    toastr.options = {closeButton: true,progressBar: true};
    @if ($errors->has('success'))
        toastr.success('{{ $errors->first('success') }}');
    @endif
    @if ($errors->has('error'))
        toastr.error('{{ $errors->first('error') }}');
    @endif

    // 后台模板自带的,视乎是做兼容处理
    if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('assets/js/jquery.mobile.custom.min.js') }}'>"+"<"+"/script>");

    // 左侧导航栏选中效果,暂时只支持二级导航
    var pathname = location.pathname;
    if (pathname != '/') {
        $(function(){
            $("a[href='"+pathname+"']").parent().addClass('active');
            $("a[href='"+pathname+"']").parent().parents('li').addClass('active open');
        })
    }
</script>

@yield('bottom')

<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

<!-- page specific plugin scripts -->

<!-- ace scripts -->
<script src="{{ asset('assets/js/ace-elements.min.js') }}"></script>
<script src="{{ asset('assets/js/ace.min.js') }}"></script>

<!-- inline scripts related to this page -->
</body>
</html>
