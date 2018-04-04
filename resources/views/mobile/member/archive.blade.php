@extends('layouts.mobile')

@section('title', '会员档案')

@section('content')
    <div class="setting-box">
        <div class="title">头像</div>
        <img id="avatar-image" src="{{avatar($uid).'?'.rand(0,10000)}}" class="avatar">
        <span id="picker"><i class="iconfont icon-edit"></i>修改</span>
    </div>
    <div class="setting-box">
        <div class="title">基本信息</div>
        <i class="edit-link iconfont icon-edit"  data-link="{{url('/mobile/member/edit')}}">修改</i>
        <div class="member-archive">
            @if($archive)
                <div class="row">
                    <div class="label">会员ID</div>
                    <div class="content">{{$archive['id']}}</div>
                </div>
                <div class="row">
                    <div class="label">姓名</div>
                    <div class="content">{{$archive['fullname']}}</div>
                </div>
                <div class="row">
                    <div class="label">性别</div>
                    <div class="content">@if($archive['sex'])男@else女@endif</div>
                </div>
                <div class="row">
                    <div class="label">电话</div>
                    <div class="content">{{$archive['phone']}}</div>
                </div>
                <div class="row">
                    <div class="label">出生日期</div>
                    <div class="content">{{$archive['birthday']}}</div>
                </div>
                <div class="row">
                    <div class="label">就读大学</div>
                    <div class="content">{{$archive['university']}}</div>
                </div>
                <div class="row">
                    <div class="label">入学年份</div>
                    <div class="content">{{$archive['enrollyear']}}</div>
                </div>
                <div class="row">
                    <div class="label">籍贯</div>
                    <div class="content">{{$archive['birthplace']}}</div>
                </div>
                <div class="row">
                    <div class="label">所在地</div>
                    <div class="content">{{$archive['location']}}</div>
                </div>
                <div class="row">
                    <div class="label">联谊会职务</div>
                    <div class="content">@if($archive['post']){{$archive['post']}}@else会员@endif</div>
                </div>
                <div class="row">
                    <div class="label">人气指数</div>
                    <div class="content"><span class="iconfont icon-favorfill" style="color: #cbb956;"></span>{{$archive['stars']}}</div>
                </div>

                <div class="row">
                    <div class="label">认证状态</div>
                    <div class="content">{{$verify_status[$archive['status']]}}</div>
                </div>
            @else
                <div class="noaccess">你还不是联谊会会员</div>
                <div class="join-btn"><a href="{{url('/mobile/join/index')}}" class="button">立即申请加入</a></div>
            @endif
        </div>
    </div>

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
