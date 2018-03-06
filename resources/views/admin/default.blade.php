<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>@yield('title', 'Title')-后台管理中心</title>
    <meta name="render" content="webkit">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/images/common/favicon.png">
    <link rel="stylesheet" type="text/css" href="/css/admin.css?{TIMESTAMP}">
    @yield('styles')
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>
    @yield('scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>
<body style="padding: 20px;">

@yield('content')

<script type="text/javascript">
    $(function () {

    });
</script>
<div class="footer" id="footer">
    <!--<p>©2015-{echo date('Y',time());} <a href="http://www.liaidi.com" target="_blank">六盘水力爱迪科技有限公司</a> 版权所有，并保留所有权利。</p>-->
</div>
<div class="blank"></div>
</body>
</html>
