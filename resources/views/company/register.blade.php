<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>企业入住</title>
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
    <div class="content-div" style="margin-top: 60px;">
        <div class="hd">
            <h3 class="title">企业注册</h3>
            <form method="post" id="Form" autocomplete="off" action="/company/register/save">
                {{csrf_field()}}
                <div class="form-group">
                    <input type="text" name="company_name" id="company_name" title="" class="text" placeholder="企业名称，请与单位证照名称一致">
                </div>
                <div class="form-group">
                    <select title="" class="select" name="province" id="province">
                        <option value="">请选择</option>
                    </select>
                    <select title="" class="select" name="city" id="city">
                        <option value="">请选择</option>
                    </select>
                    <select title="" class="select" name="district" id="district">
                        <option value="">请选择</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="contact" id="contact" title="" class="text" placeholder="招聘联系人，填写联系人姓名">
                </div>
                <div class="form-group">
                    <input type="text" name="mobile" id="mobile" title="" class="text" placeholder="手机号">
                </div>
                <div class="form-group">
                    <input type="text" name="email" id="email" title="" class="text" placeholder="电子邮箱">
                </div>
                <div class="form-group">
                    <input type="text" name="username" id="username" title="" class="text" placeholder="用户名，长度6-24位字符">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" title="" class="text" placeholder="设置密码，8-20位">
                </div>
                <div class="sign-button-div"><button type="submit" id="btnlogin" class="sign-button">立即注册</button></div>
                <div class="sign-link">
                    <span><a href="/company/login">已有账号，点此立即登录</a></span>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="app-footer"></div>
<script type="text/javascript">
    var dist = new DistrictSelector({
        province:'贵州省',
        city:'六盘水市',
        district:'盘州市'
    });
    $("#Form").on('submit', function () {
        var company_name = $.trim($("#company_name").val());
        if (!company_name) {
            DSXUI.error('请填写企业名称');
            return false;
        }

        var province = $("#province").val();
        if (!province) {
            DSXUI.error('请选择所在省');
            return false;
        }

        var city = $("#city").val();
        if (!city) {
            DSXUI.error('请选择所在城市');
            return false;
        }

        var district = $("#district").val();
        if (!district) {
            DSXUI.error('请选择所在区县');
            return false;
        }

        var contact = $("#contact").val();
        if (!contact) {
            DSXUI.error('请填写招聘联系人');
            return false;
        }

        var mobile = $("#mobile").val();
        if (!DSXValidate.IsMobile(mobile)) {
            DSXUI.error('请填写手机号码');
            return false;
        }

        var email = $("#email").val();
        if (!DSXValidate.IsEmail(email)) {
            DSXUI.error('请填写电子邮箱');
            return false;
        }

        var username = $("#username").val();
        if (!DSXValidate.IsUserName(username)) {
            DSXUI.error('请填写用户名');
            return false;
        }

        var password = $("#password").val();
        if (!DSXValidate.IsPassword(password)) {
            DSXUI.error('请填写登录密码');
            return false;
        }
        var check = true;
        if (check) {
            $.ajax({
                async:false,
                url:"/company/register/check",
                type:'POST',
                data:{field:'company_name', value:company_name},
                succeess:function (response) {
                    if (response.errcode !== 0){
                        check = false;
                        DSXUI.error(response.errmsg);
                    }
                }
            });
        }

        if (check) {
            $.ajax({
                async:false,
                url:"/company/register/check",
                type:'POST',
                data:{field:'mobile', value:mobile},
                succeess:function (response) {
                    if (response.errcode !== 0){
                        check = false;
                        DSXUI.error(response.errmsg);
                    }
                }
            });
        }

        if (check) {
            $.ajax({
                async:false,
                url:"/company/register/check",
                type:'POST',
                data:{field:'email', value:email},
                succeess:function (response) {
                    if (response.errcode !== 0){
                        check = false;
                        DSXUI.error(response.errmsg);
                    }
                }
            });
        }

        if (check) {
            $.ajax({
                async:false,
                url:"/company/register/check",
                type:'POST',
                data:{field:'username', value:username},
                succeess:function (response) {
                    if (response.errcode !== 0){
                        check = false;
                        DSXUI.error(response.errmsg);
                    }
                }
            });
        }

        return check;
    });
</script>
</body>
</html>
