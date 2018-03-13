@extends('layouts.account')

@section('title', '注册')

@section('content')
    <div class="sign-body">
        <div class="sign-box-div">
            <h3>快速注册</h3>
            <div class="sign-content">
                <form method="post" action="/account/register/save" id="registerForm" autocomplete="off">
                    {{csrf_field()}}
                    <div class="err-tips" id="err-tips"></div>
                    <div class="input-div">
                        <div class="ico-box"><i class="iconfont icon-my"></i></div>
                        <div class="input-box"><input type="text" class="text" id="username" name="username" placeholder="昵称,怎么称呼你"></div>
                    </div>
                    <div class="input-div">
                        <div class="ico-box"><i class="iconfont icon-mobile"></i></div>
                        <div class="input-box"><input type="text" class="text" id="mobile" name="mobile" placeholder="请填写手机号码"></div>
                    </div>
                    <div class="input-div">
                        <div class="ico-box"><i class="iconfont icon-lock"></i></div>
                        <div class="input-box"><input type="password" class="text" id="password" name="password" placeholder="登录密码,6-20位"></div>
                    </div>
                    <div class="sign-button-div"><button type="submit" class="sign-button">注册</button></div>
                    <div class="sign-link" style="text-align:center;">
                        <a href="/account/login">已有账号, 点此登录</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $("#registerForm").submit(function(e) {
            var username = $.trim($("#username").val());
            var mobile   = $.trim($("#mobile").val());
            var password = $.trim($("#password").val());
            var showTips = function (text) {
                $("#err-tips").text(text).show();
            }
            if(!DSXValidate.IsUserName(username)){
                showTips('用户名输入错误');
                return false;
            }
            if(!DSXValidate.IsMobile(mobile)){
                showTips('手机号输入错误');
                return false;
            }
            if(!DSXValidate.IsPassword(password)){
                showTips('密码输入错误')
                return false;
            }
            var checkflag = true;
            $.ajax({
                url:"/account/register/check",
                data:{field:'username',value:username},
                dataType:"json",
                async:false,
                success: function(response){
                    if(response.errcode !== 0){
                        checkflag = false;
                        showTips('{{trans('member.username be occupied')}}');
                    }
                }
            });
            if (!checkflag) return;

            $.ajax({
                url:"/account/register/check",
                data:{field:'mobile', value:mobile},
                dataType:"json",
                async:false,
                success: function(response){
                    if(response.errcode !== 0){
                        checkflag = false;
                        showTips('{{trans('member.mobile be occupied')}}');
                    }
                }
            });
            if (!checkflag) return;

            var spinner = null;
            $("#registerForm").ajaxSubmit({
                dataType:'json',
                beforeSend:function () {
                    spinner = DSXUI.showSpinner();
                },
                success:function (response) {
                    setTimeout(function () {
                        spinner.close();
                        if (response.errcode === 0){
                            window.location.href = "/member";
                        }else {
                            showTips(response.errmsg);
                        }
                    }, 500);
                }
            });
            return false;
        });
    </script>
@stop
