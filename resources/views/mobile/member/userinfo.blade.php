@extends('layouts.mobile')

@section('title', '个人信息')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/iconfont.css')}}" type="text/css">
@stop

@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('css/date.css')}}">
    <div class="resume">
        <form method="post" id="Form" style="padding: 10px 0;">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <div class="form-wrap">
                <div class="setting-box">
                    <div class="title">头像</div>
                    <img id="avatar-image" src="{{avatar($uid).'?'.rand(0,10000)}}" class="avatar">
                    <span id="picker"><i class="iconfont icon-edit"></i>修改</span>
                </div>
                <div class="form-group">
                    <div class="label">昵称</div>
                    <div class="content"><input type="text" class="input-text" name="user[name]" id="name" value="{{$member['username']}}" placeholder="你的昵称"></div>
                </div>
                <div class="form-group">
                    <div class="label">姓名</div>
                    <div class="content"><input type="text" class="input-text" name="user[fullname]" id="fullname" value="{{$user['name']}}" placeholder="真实姓名"></div>
                </div>
                <div class="form-group">
                    <div class="label">性别</div>
                    <div class="content" style="padding-top: 7px">
                        <label><input type="radio" class="radio" name="user[sex]" value="0"@if($user['sex']==0) checked="checked"@endif> 女</label>
                        <label><input type="radio" class="radio" name="user[sex]" value="1"@if($user['sex']==1) checked="checked"@endif> 男</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">生日</div>
                    <div class="content"><input type="text" class="input-text" name="user[birthday]" id="birthday" value="{{$user['birthday']}}" placeholder="生日"></div>
                </div>
                <div class="form-group">
                    <div class="label">电话</div>
                    <div class="content"><input type="text" class="input-text" name="user[phone]" id="phone" value="{{$member['mobile']}}" placeholder="电话号码"></div>
                </div>
                <div class="form-group">
                    <div class="label">QQ</div>
                    <div class="content"><input type="text" class="input-text" name="user[qq]" id="qq" value="{{$user['qq']}}" placeholder="qq号码"></div>
                </div>
                <div class="form-group">
                    <div class="label">邮箱</div>
                    <div class="content"><input type="text" class="input-text" name="user[email]" id="email" value="{{$member['email']}}" placeholder="联系邮箱"></div>
                </div>
                <div class="form-group">
                    <div class="label">自我介绍</div>
                    <div class="content">
                        <textarea class="textarea" name="user[introduction]" id="introduction" placeholder="简单简绍一下你自己">{{$user['introduction']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"></div>
                    <div class="content">
                        <button type="button" id="submit" class="button">保存</button>
                    </div>
                </div>
            </div>
        </form>
        <div id="datePlugin"></div>
    </div>
    <link href="{{asset('webuploader/webuploader.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('webuploader/webuploader.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/date.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        var nowDate = new Date();
        var date = $('#birthday').val().split('-');
        var byear = date[0]?date[0]:'2000';
        var bmonth = date[1]?date[1]:'1';
        var bday = date[2]?date[2]:'1';
        console.log(byear,bmonth,bday);
        $('#birthday').date({
            setY:byear,
            setM:bmonth,
            setD:bday,
            curdate:false
        });
        $("#submit").on('click', function () {
            var name = $.trim($("#name").val());
            if (!name) {
                DSXUI.error('请填写姓名');
                return false;
            }

            var phone = $.trim($("#phone").val());
            if (!phone) {
                DSXUI.error('请填写电话号码');
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
                            window.location.href = '{{url('/mobile/member')}}';
                        }else {
                            DSXUI.error(response.errmsg);
                        }
                    }, 500);
                }
            });
        });
        var spinner = null;
        // 初始化Web Uploader
        var uploader = WebUploader.create({
            // 选完文件后，是否自动上传。
            auto: true,
            // swf文件路径
            swf: '{{asset('webuploder/Uploader.swf')}}',
            // 文件接收服务端。
            server: "{{url('/member/settings/set_avatar')}}",
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#picker',
            // 只允许选择图片文件。
            multiple:false,
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,png',
                mimeTypes: 'image/*'
            },
            fileVal:"file",
            formData:{'_token':'{{csrf_token()}}'}
        });

        // 文件上传过程中创建进度条实时显示。
        uploader.on( 'uploadStart', function( file, percentage ) {
            if (!spinner) spinner = DSXUI.showSpinner();
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file , response) {
            setTimeout(function () {
                spinner.close();
                $("#avatar-image").attr('src', '{{avatar($uid)}}&'+Math.random());
            }, 500);
        });

        // 文件上传失败，显示上传出错。
        uploader.on( 'uploadError', function( file, reason ) {
            alert(JSON.stringify(reason));
        });
    </script>
@stop
