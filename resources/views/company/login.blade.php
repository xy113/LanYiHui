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
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('images/common/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('css/company.css')}}" type="text/css">
    <script src="{{asset('js/jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/common.js')}}" type="text/javascript"></script>
</head>
<body>
<div class="app-login">
    <div class="content-div">
        <div class="hd">
            <h3 class="title">企业登录</h3>
            <form method="post" id="loginForm" autocomplete="off" action="/company/login/check">
                {{csrf_field()}}
                <input type="hidden" id="J_refer" name="refer" value="{{$redirect or ''}}">
                <div class="input-div">
                    <div class="ico-box"><i class="iconfont icon-my"></i></div>
                    <div class="input-box"><input type="text" class="text" id="account" name="account" placeholder="用户名/手机号/邮箱"></div>
                </div>
                <div class="input-div">
                    <div class="ico-box"><i class="iconfont icon-lock"></i></div>
                    <div class="input-box"><input type="password" class="text" id="password" name="password" placeholder="密码" maxlength="20"></div>
                </div>
                <div class="input-div">
                    <div class="ico-box"><i class="iconfont icon-attention_light"></i></div>
                    <div class="input-box">
                        <input type="text" name="captcha" class="text" id="captcha" placeholder="验证码" maxlength="4">
                        <img src="{{captcha_src()}}" onclick="this.src='{{captcha_src()}}&'+Math.random()" title="看不清，换一张" class="captcha" id="captchaImg">
                    </div>
                </div>
                <div class="sign-button-div"><button type="button" id="btnlogin" class="sign-button">登录</button></div>
                <div class="sign-link">
                    <span><a href="/account/findpass">忘记密码?</a></span>
                    <a href="/company/register">注册新账号</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="app-footer"></div>
<script type="text/javascript">
    $("#btnlogin").on('click', function () {
        var account = $.trim($("#account").val());
        var password = $.trim($("#password").val());

        if (!account) {
            DSXUI.error('请输入账号');
            return false;
        }

        if (!password) {
            DSXUI.error('请输入密码');
            return false;
        }

        var captcha = $("#captcha").val();
        if (captcha.length !== 4) {
            DSXUI.error('请输入验证码');
            return false;
        }

        $("#loginForm").ajaxSubmit({
            dataType:'json',
            success:function (response) {
                if (response.errcode === 0){
                    window.location.href = '/company';
                }else {
                    DSXUI.error(response.errmsg);
                }
            }
        });
    });
</script>
</body>
</html>
