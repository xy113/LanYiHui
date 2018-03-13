<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>@yield('title', '企业管理中心')</title>
    <meta name="keywords" content="@yield('keywords', setting('keywrods'))">
    <meta name="description" content="@yield('description', setting('description'))">
    <meta name="render" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('images/common/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('css/company.css')}}" type="text/css">
    @yield('styles')
    <script src="{{asset('js/jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/common.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/angular.min.js')}}" type="text/javascript"></script>
    @yield('scripts')
</head>
<body class="body">

<div class="header-topbar">
    <div class="float-right">
        <div class="account">
            <a>
                <img src="{{avatar($uid)}}" class="avatar">
                <span class="username">{{$company_name or ''}}</span>
            </a>
        </div>
    </div>
    <h1 class="title">企业管理中心</h1>
</div>

<div class="wrapper">
    <div class="sidebar">
        <ul class="menus">
            <li class="active">
                <a href="/company">
                    <span class="iconfont icon-settings"></span>
                    <span>资料设置</span>
                </a>
            </li>
            <li>
                <a href="/company/security">
                    <span class="iconfont icon-safe"></span>
                    <span>安全设置</span>
                </a>
            </li>
            <li>
                <a href="/company/job">
                    <span class="iconfont icon-form_light"></span>
                    <span>招聘管理</span>
                </a>
            </li>
            <li>
                <a href="/company/resume">
                    <span class="iconfont icon-profilefill"></span>
                    <span>简历管理</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="page-wrapper">
        @yield('content')
        <div id="footer">
            <div class="area">
                <div class="bottomNav">
                    <a href="javascript:;">关于我们</a><span>|</span>
                    <a href="javascript:;">联系方式</a><span>|</span>
                    <a href="javascript:;">广告服务</a><span>|</span>
                    <a href="javascript:;">法律援助</a><span>|</span>
                    <a href="javascript:;">加入我们</a><span>|</span>
                    <a href="javascript:;">支付方式</a><span>|</span>
                    <a href="javascript:;">技术支持</a>
                </div>

                <div class="copyright">{{setting('copyright')}}   {{setting('icp')}}</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
