@extends('layouts.member')

@section('content')
    <div class="console-title">
        <ul class="tab">
            <li class="on"><a>基本信息</a></li>
            <li><a href="/member/settings/security">安全设置</a></li>
            <li><a href="/member/settings/verify">实名认证</a></li>
        </ul>
    </div>
    <div class="blank"></div>
    <div class="avatar-div">
        <div class="avatar"><img id="avatar-image" src="{{avatar($uid)}}"></div>
        <div class="avatar-content">
            <a id="picker">
                修改头像
            </a>
        </div>
        <div class="avatar-content">支持JPG,JPEG,GIF,PNG格式</div>
    </div>
    <div class="userinfo-div">
        <form method="post" id="userinfoForm">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formtable">
                <tr>
                    <td width="64">性别</td>
                    <td>
                        @foreach($sex_items as $k=>$v)
                        <input title="" type="radio" value="{{$k}}" name="memberinfo[sex]"@if($k==$memberinfo['sex']) checked="checked"@endif> {{$v}}
                        @endforeach
                    </td>
                    <td width="40">生日</td>
                    <td><input title="" type="text" class="input-text" name="memberinfo[birthday]" onclick="WdatePicker()" value="{{$memberinfo['birthday']}}" readonly></td>
                </tr>
                <tr>
                    <td>星座</td>
                    <td>
                        <select title="" class="input-select" name="memberinfo[star]">
                            @foreach(trans('member.star_items') as $k=>$v)
                            <option value="{{$k}}"@if($k==$memberinfo['star']) selected="selected"@endif>{{$v}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>血型</td>
                    <td>
                        <select title="" class="input-select" name="memberinfo[blood]">
                            @foreach(trans('member.blood_items') as $k=>$v)
                            <option value="{{$k}}"@if($k==$memberinfo['blood']) selected="selected"@endif>{{$v}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>QQ</td>
                    <td><input title="" type="text" class="input-text" name="memberinfo[qq]" value="{{$memberinfo['qq']}}"></td>
                    <td>微信</td>
                    <td><input title="" type="text" class="input-text" name="memberinfo[weixin]" value="{{$memberinfo['weixin']}}"></td>
                </tr>
                <tr>
                    <td>所在地</td>
                    <td colspan="3">
                        <select title="" class="input-select dist select" id="province" name="memberinfo[province]" style="width:auto;">
                            <option value="">请选择</option>
                        </select>
                        <select title="" class="input-select dist select" id="city" name="memberinfo[city]" style="width:auto;">
                            <option value="">请选择</option>
                        </select>
                        <select title="" class="input-select dist select" id="district" name="memberinfo[district]" style="width:auto;">
                            <option value="">请选择</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>个人描述</td>
                    <td colspan="3"><textarea title="" name="memberinfo[introduction]" class="textarea" draggable="false" style="width:500px; height:80px;">{{$memberinfo['introduction']}}</textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3"><button type="submit" class="button">更新资料</button></td>
                </tr>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        (function () {
            new DistrictSelector({
                province:'{{$memberinfo['province']}}',
                city:'{{$memberinfo['city']}}',
                district:'{{$memberinfo['district']}}'
            });
        })();
    </script>
    <link href="{{asset('webuploader/webuploader.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('webuploader/webuploader.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
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
