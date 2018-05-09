<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>@yield('title', setting('sitename'))</title>
    <meta name="keywords" content="@yield('keywords', setting('keywords'))">
    <meta name="description" content="@yield('description', setting('description'))">
    <meta name="render" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    {{--<META HTTP-EQUIV="Pragma" CONTENT="no-cache">--}}
    {{--<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">--}}
    {{--<META HTTP-EQUIV="Expires" CONTENT="0">--}}
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('images/common/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('css/mobile.css')}}" type="text/css">
    @yield('styles')
    <script src="{{asset('js/jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.cookie.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/common.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.mobile.touch.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/vue.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/vue-resource@1.5.0')}}" type="text/javascript"></script>
    @yield('scripts')
    <script type="text/javascript">
        var g_config = {
            baseUrl : '{{url('/')}}',

        }
        window.redirect = function (url) {
            window.location.href = url;
        }
    </script>
</head>
<body>
<div class="page">
    @yield('content', '')
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("[data-link]").on('tap', function () {
            if ($(this).attr('data-link')){
                window.location.href = $(this).attr('data-link');
            }
        });
    });
</script>
</body>
</html>
