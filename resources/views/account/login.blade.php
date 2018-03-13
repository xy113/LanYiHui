@extends('layouts.account')

@section('content')
    <div class="area main-body-div">
        <div class="sign-in-map"></div>
        <div class="sign-in-div">
            <div class="content" id="loginView">
                <h3>快速登录</h3>
                <div class="sign-content">
                    <form method="post" id="loginForm" autocomplete="off">
                        {{csrf_field()}}
                        <input type="hidden" id="J_refer" name="refer" value="{{$redirect}}">
                        <div class="err-tips" id="err-tips"></div>
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
                        <div class="sign-button-div"><button type="submit" id="btnlogin" class="sign-button">登录</button></div>
                        <div class="sign-link">
                            <span><a href="/account/findpass">忘记密码?</a></span>
                            <a href="/account/register">注册新账号</a>
                        </div>
                    </form>
                </div>
                <div class="saoma-login" id="saoma-login"></div>
            </div>

            <div class="content" id="saomaView" style="display: none;">
                <h3>手机扫码，安全登录</h3>
                <div class="scan-login">
                    <img id="qrcode" class="qrcode" title="">
                    <div class="qrcode-desc">打开手机APP 扫一扫登录</div>
                </div>
                <div class="diannao-login" id="diannao-login"></div>
                <div class="loading" id="loading"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var timer = null;
        function scanQuery() {
            $.ajax({
                dataType:'json',
                url:"/account/login/scan",
                success:function (response) {
                    if (response.errcode === 0){
                        confirmLogin();
                    }else {
                        timer = setTimeout(function () {
                            scanQuery();
                        }, 1000);
                    }
                }
            });
        }
        function confirmLogin() {
            $.ajax({
                dataType:'json',
                url:"/account/login/confirm",
                beforeSend:function () {
                    $("#loading").show();
                },
                success:function (response) {
                    if (response.errcode === 0){
                        $("#loading").hide();
                        setTimeout(function () {
                            if ($("#J_refer").val()){
                                window.location.href = $("#J_refer").val();
                            }else {
                                DSXUtil.reFresh();
                            }
                        }, 1000);
                    }else {
                        DSXUI.error(response.errmsg);
                    }
                }
            });
        }
        $(function () {
            function checkLogin() {
                var account = $("#account").val();
                if(!DSXValidate.IsUserName(account) && !DSXValidate.IsMobile(account) && !DSXValidate.IsEmail(account)){
                    $("#err-tips").text('账号输入错误').show();
                    return false;
                }
                var password = $("#password").val();
                if(!DSXValidate.IsPassword(password)){
                    $("#err-tips").text('密码错误').show();
                    return false;
                }
                var captcha = $("#captcha").val();
                if(captcha.length !== 4){
                    $("#err-tips").text('验证码错误').show();
                    return false;
                }
                $.ajax({
                    type:'POST',
                    url:"/account/login/check",
                    async:false,
                    dataType:"json",
                    data:$("#loginForm").serializeArray(),
                    success: function(json){
                        if(json.errcode === 0){
                            if ($("#J_refer").val()){
                                window.location.href = $("#J_refer").val();
                            }else {
                                DSXUtil.reFresh();
                            }
                        }else {
                            $("#captchaImg").attr('src','{{captcha_src()}}&'+Math.random());
                            $("#err-tips").text(json.errmsg).show();
                        }
                    }
                });
                return false;
            }
            $("#saoma-login").on('click', function () {
                $("#loginView").hide();
                $("#saomaView").show();
                $("#qrcode").attr("src","/account/login/qrcode");
                scanQuery();
            });
            $("#diannao-login").on('click', function () {
                $("#loginView").show();
                $("#saomaView").hide();
                clearTimeout(timer);
            });
            $("#loginForm").on('submit', checkLogin);
        });
    </script>
@stop
