@extends('layouts.mobile')

@section('title', '会员档案')

@section('content')
    <div class="setting-box">
        <div class="title">基本信息</div>
        <div class="member-archive">
            @if($archive)
                <i class="edit-link iconfont icon-edit"  data-link="{{url('/mobile/member/edit')}}">修改</i>
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

@stop
