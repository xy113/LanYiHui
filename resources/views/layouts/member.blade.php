<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>@yield('title', '用户中心')</title>
    <meta name="keywords" content="@yield('keywords', setting('keywords'))">
    <meta name="description" content="@yield('description', setting('description'))">
    <link href="{{asset('images/common/favicon.png')}}" rel="icon">
    <link href="{{asset('css/member.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('js/jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/common.js')}}" type="text/javascript"></script>
</head>
<body>

<div class="membercp-header">
    <div class="area header">
        <strong class="logo"><img src="{{asset('images/common/grzx_logo.png')}}"></strong>
        <div class="right-menu">
            <a href="{{url('/')}}">网站首页</a>
            <a href="{{url('member/settings/userinfo')}}">账户中心</a>
            <a href="{{url('member/wallet')}}">财务中心</a>
            <a href="{{url('admin')}}">后台管理</a>
            <a href="{{url('account/logout')}}">退出登录</a>
        </div>
    </div>
</div>
<div style="height: 30px; display: block; clear: both;"></div>
<div class="area">
    <div class="sidebar">
        <div class="sidebar-content">
            <dl>
                <dd><a><i class="iconfont icon-peoplefill"></i>我的账户</a></dd>
                <dt>
                    <ul>
                        <li><a href="{{url('member/settings/userinfo')}}"@if($menu==='userinfo') class="cur"@endif>账户设置</a></li>
                        <li><a href="{{url('member/settings/security')}}"@if($menu==='security') class="cur"@endif>安全中心</a></li>
                        <li><a href="{{url('member/settings/archive')}}"@if($menu==='archive') class="cur"@endif>会员档案</a></li>
                        <li><a href="{{url('member/resume')}}"@if($menu==='resume') class="cur"@endif>我的简历</a></li>
                        <li><a href="{{url('member/collection/article')}}"@if($menu==='collection') class="cur"@endif>我的收藏</a></li>
                    </ul>
                </dt>
            </dl>
            <dl>
                <dd><a><i class="iconfont icon-formfill"></i>信息管理</a></dd>
                <dt>
                    <ul>
                        <li><a href="{{url('member/post')}}"@if($menu==='post') class="cur"@endif>我的文章</a></li>
                        <li><a href="{{url('member/topic')}}"@if($menu==='topic') class="cur"@endif>我的话题</a></li>
                    </ul>
                </dt>
            </dl>
        </div>
    </div>
    <div class="mainframe">
        <div class="main-content">
            @yield('content', '')
        </div>
    </div>
</div>
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
</body>
</html>
