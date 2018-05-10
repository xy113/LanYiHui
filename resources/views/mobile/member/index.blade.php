@extends('layouts.mobile')

@section('title', '个人中心')
@section('styles')
<link rel="stylesheet" href="{{asset('css/iconfont.css')}}" type="text/css">
@stop
@section('content')
    <div class="mine-header"  style="background-image: {{$background}}" onclick="">
        <div class="content">
            <img src="{{avatar($uid)}}" class="avatar"  data-link="{{url('/mobile/member/userinfo')}}">
            <div class="name"  data-link="{{url('/mobile/member/userinfo')}}">@if($username){{$username}}@else未登录@endif</div>
            <div class="bg-mb"></div>
        </div>
    </div>
    <div class="tableview">
        <div class="row" data-link="{{url('/mobile/member/archive')}}">
            <div class="cell cell-icon"><span class="iconfont icon-yonghu"></span></div>
            <div class="cell cell-text">会员档案</div>
        </div>
        <div class="row" data-link="{{url('/mobile/resume')}}">
            <div class="cell cell-icon"><span class="iconfont icon-text"></span></div>
            <div class="cell cell-text">我的简历</div>
        </div>
        <div class="row" data-link="{{url('/mobile/schoolfellow/index')}}">
            <div class="cell cell-icon"><span class="iconfont icon-group_fill"></span></div>
            <div class="cell cell-text">我的校友</div>
        </div>
        <div class="row" data-link="{{url('/mobile/resume/deliver')}}">
            <div class="cell cell-icon"><span class="iconfont icon-creative"></span></div>
            <div class="cell cell-text">我的投递</div>
        </div>
        <div class="row" data-link="{{url('/mobile/favorite')}}">
            <div class="cell cell-icon"><span class="iconfont icon-favor"></span></div>
            <div class="cell cell-text">我的收藏</div>
        </div>
        <div class="row" data-link="{{url('/mobile/message')}}">
            <div class="cell cell-icon"><span class="iconfont icon-lyb"></span></div>
            <div class="cell cell-text">我的留言</div>
        </div>
        <div class="row" data-link="{{url('/mobile/feedback')}}">
            <div class="cell cell-icon"><span class="iconfont icon-fankui"></span></div>
            <div class="cell cell-text">意见反馈</div>
        </div>
        <form style="display: none" method="post" action="{{url('mobile/background/upload')}}">
        </form>
        @if($username)
        <div style="text-align: center; margin: 1rem auto">
            <button onclick="logout()" class="error-btn big">
                退出登陆
            </button>
        </div>
            @endif
    </div>
    @include('mobile.tabbar', ['tab' => 'mine'])
    <script>
        function logout() {
            if (confirm('是否确认退出登陆？')){
                window.location = '{{url('account/logout')}}';
            }
        }
    </script>
@stop
