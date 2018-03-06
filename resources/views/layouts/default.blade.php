<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>@yield('title', 'Default Title')</title>
    <meta name="keywords" content="@yield('keywords', 'keywrods')">
    <meta name="description" content="@yield('description', 'description')">
    <meta name="render" content="webkit">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/angular.min.js" type="text/javascript"></script>
    @yield('scripts')
    <link rel="icon" href="/static/images/common/favicon.png">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    @yield('styles')
</head>
<body>

@yield('content')

</body>
</html>
