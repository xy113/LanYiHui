@extends('layouts.mobile')

@section('title', '登录')

@section('content')
    <div class="sign">
        <form method="post" id="Form" autocomplete="off">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <div class="form-group">
                <input type="text" class="input-text" title="" name="account" id="account" placeholder="手机号/邮箱">
            </div>
            <div class="form-group">
                <input type="password" class="input-text" title="" name="password" id="password" placeholder="登录密码">
            </div>
            <div class="form-group">
                <button type="button" class="button" id="loginBtn">登录</button>
            </div>
            <div class="blank"></div>
            <div class="link">
                <a href="{{url('/mobile/register?redirect='.urlencode($redirect))}}">注册账号</a>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        var redirect = '{{$redirect}}';
        $("#loginBtn").on('click', function () {
            var account = $.trim($("#account").val());
            if (!DSXValidate.IsMobile(account) && !DSXValidate.IsEmail(account)){
                DSXUI.error('账号输入有误');
                return false;
            }
            var password = $.trim($("#password").val());
            if (!DSXValidate.IsPassword(password)) {
                DSXUI.error('密码输入错误');
                return false;
            }
            var spinner = null;
            $("#Form").ajaxSubmit({
                dataType:'json',
                beforeSend:function () {
                    spinner = DSXUI.showSpinner();
                },
                success:function (response) {
                    setTimeout(function () {
                        spinner.close();
                        if (response.errcode === 0){
                            if (redirect) {
                                window.location.href = redirect;
                            }else {
                                window.location.href = '/mobile/member'
                            }
                        }else {
                            DSXUI.error(response.errmsg);
                        }
                    }, 500);
                }
            });
        })
    </script>
@stop
