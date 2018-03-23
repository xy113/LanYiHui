@extends('layouts.mobile')

@section('title', '个人中心')

@section('content')
    <div class="mine-header">
        <div class="content">
            <img src="{{avatar($uid)}}" class="avatar">
            <div class="name">{{$username}}</div>
        </div>
    </div>
    <div class="tableview">
        <div class="row">
            <div class="cell cell-icon"><span class="iconfont icon-yonghu"></span></div>
            <div class="cell cell-text">会员资料</div>
        </div>
        <div class="row" data-link="{{url('/mobile/resume')}}">
            <div class="cell cell-icon"><span class="iconfont icon-text"></span></div>
            <div class="cell cell-text">我的简历</div>
        </div>
        <div class="row" data-link="{{url('/mobile/favorite')}}">
            <div class="cell cell-icon"><span class="iconfont icon-favor"></span></div>
            <div class="cell cell-text">我的收藏</div>
        </div>
        <div class="row">
            <div class="cell cell-icon"><span class="iconfont icon-fankui"></span></div>
            <div class="cell cell-text">意见反馈</div>
        </div>
    </div>
    @include('mobile.tabbar', ['tab' => 'mine'])
@stop
