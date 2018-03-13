<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>@yield('title', '用户中心')</title>
    <meta name="keywords" content="@yield('keywords', setting('keywords'))">
    <meta name="description" content="@yield('description', setting('description'))">
    <link rel="icon" href="{{asset('images/common/favicon.png')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/member.css')}}">
    <script src="{{asset('js/jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/common.js')}}" type="text/javascript"></script>
</head>
<body>

<div class="membercp-header">
    <div class="area header">
        <strong class="logo"><img src="{{asset('images/common/grzx_logo.png')}}"></strong>
        <div class="right-menu">
            <a href="/">网站首页</a>
            <a href="/member/setting">账户中心</a>
            <a href="/member/wallet">财务中心</a>
            <a href="/admin">后台管理</a>
            <a href="/account/logout">退出登录</a>
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
                        <li><a href="/member/settings/userinfo"@if($menu==='userinfo') class="cur"@endif>账户设置</a></li>
                        <li><a href="/member/settings/security"@if($menu==='security') class="cur"@endif>安全中心</a></li>
                        <li><a href="/member/wallet"@if($menu==='wallet') class="cur"@endif>我的钱包</a></li>
                        <li><a href="/member/address"@if($menu==='address') class="cur"@endif>收货地址</a></li>
                        <li><a href="/member/collection/article"@if($menu==='collection') class="cur"@endif>我的收藏</a></li>
                        <li><a href="/member/comment"@if($menu==='comment') class="cur"@endif>我的评论</a></li>
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
