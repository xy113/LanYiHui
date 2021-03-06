<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>后台管理中心</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        body {padding:0; margin:0; font:12px Arial; background-color:#CCC; background-size:cover; position:relative;}
        a:link,a:active,a:visited{color:#333333; text-decoration:none;}
        a:hover{color:#FF0000; text-decoration:underline;}
        .login-wrap{background:#fff; border-radius:5px; margin:100px auto; width:400px; box-shadow:0 3px 5px #333;}
        .login-wrap .title{font-size:20px; margin:0 0 10px 0; padding:20px 0; text-align:center; border-radius:5px 5px 0 0; border-bottom:1px #eee solid;}
        .login-wrap .item{padding:15px 0; text-align:center;}
        .login-wrap .input-text{font-size:14px; width:260px; padding:5px 0; border-radius:2px; height:40px; line-height:40px; text-align:center; box-sizing:border-box; border-width:1px; border:1px #CCC solid;}
        .login-wrap .input-text:hover{border-color:#09C; background-color:#f9f9f9;}
        .login-wrap .button{width:270px; height:40px; line-height:40px; margin-bottom:20px; cursor:pointer; font-size:16px; font-weight:bold; background:#C30; border-radius:3px; color:#fff; text-align:center; display:inline-block; box-sizing:border-box;}
        .login-wrap .button:hover{background:#C03;}
        .login-wrap .err{color:#F00; text-align:center; font-size:12px; display:none;}
        .copyright{position:fixed; bottom:30px; width:100%; display:block; text-align:center;}
        .copyright,.copyright *,.copyright a{font:400 12px Arial; color:#fff;}
    </style>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <link rel="icon" href="/images/common/favicon.png" />
</head>
<body style="background:url(http://service.dsxcms.com/background.php);">
<div class="login-wrap">
    <form method="post" id="formlogin" action="/admin/checklogin">
        {{csrf_field()}}
        <h1 class="title">登录后台管理中心</h1>
        <div class="err" id="err"></div>
        <div class="item"><input type="text" name="account" value="{{$username or ''}}" id="account" class="input-text" placeholder="用户名/手机号/邮箱"></div>
        <div class="item"><input type="password" name="password" id="password" class="input-text" placeholder="密码"></div>
        <div class="item"><div class="button" tabindex="1" id="loginButton">登录</div></div>
    </form>
</div>
<script type="text/javascript">
    (function(){
        var form = $("#formlogin");
        function submitLogin(){
            var account = form.find("input[name=account]").val();
            var password = form.find("input[name=password]").val();
            if (!account) {
                $("#err").text('请输入账号').show();
                return false;
            }
            if(!DSXValidate.IsPassword(password)){
                $("#err").text('请输入密码').show();
                return false;
            }
            form.ajaxSubmit({
                dataType:'json',
                success:function(json){
                    if(json.errcode === 0){
                        window.location.href = '/admin';
                    }else{
                        $("#err").text('密码输入错误').show();
                    }
                }
            });
        }
        form.find("input").blur(function(e) {
            $("#err").empty().hide();
        }).keydown(function(e) {
            if(e.which === 13){
                submitLogin();
            }
        });
        $("#loginButton").click(function(e) {
            return submitLogin();
        });
    })();
</script>
<p class="copyright">&copy;{{date('Y')}} <a href="http://www.songdewei.com" target="_blank">贵州大师兄信息技术有限公司</a> 版权所有，并保留所有权利。</p>
</body>
</html>
