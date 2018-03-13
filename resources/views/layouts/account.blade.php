<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>@yield('title', setting('sitename'))</title>
    <meta name="keywords" content="@yield('keywords', setting('keywords'))">
    <meta name="description" content="@yield('description', setting('description'))">
    <link rel="icon" href="{{asset('images/common/favicon.png')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/account.css')}}">
    <script src="{{asset('js/jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/common.js')}}" type="text/javascript"></script>
</head>
<body>

@yield('content', '')

<div class="footer" id="footer">
    <div class="area">
        <div class="bottomNav">
            <a href="/">网站首页</a>
            <span class="split">|</span>
            <a href="#">关于我们</a>
            <span class="split">|</span>
            <a href="#">联系方式</a>
            <span class="split">|</span>
            <a href="#">广告服务</a>
            <span class="split">|</span>
            <a href="#">法律援助</a>
            <span class="split">|</span>
            <a href="#">加入我们</a>
            <span class="split">|</span>
            <a href="#">支付方式</a>
            <span class="split">|</span>
            <a href="#">技术支持</a>
        </div>
        <div class="copyright">{{setting('copyright')}}   {{setting('icp')}}</div>
    </div>
</div>
</body>
</html>
