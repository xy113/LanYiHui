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
            <a class="button upload-button">
                <span>上传头像</span>
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
        var dist = new DistrictSelector({
            province:'{{$memberinfo['province']}}',
            city:'{{$memberinfo['city']}}',
            district:'{{$memberinfo['district']}}'
        });
        $("#J-file").change(function(){
            var loading;
            $("#upload-avatar-form").ajaxSubmit({
                dataType:'json',
                beforeSend:function(){
                    loading = DSXUI.showloading('照片上传中...');
                },
                success:function(json){
                    if(json.errcode === 0){
                        loading.close();
                        $("#avatar-image").attr('src', json.data.avatar+'#'+Math.random());
                    }
                }
            });
        });
    </script>
@stop
