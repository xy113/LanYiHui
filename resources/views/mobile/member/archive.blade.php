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
                {{--<div class="row">--}}
                    {{--<div class="label">就读大学</div>--}}
                    {{--<div class="content">{{$archive['university']}}</div>--}}
                {{--</div>--}}
                {{--<div class="row">--}}
                    {{--<div class="label">入学年份</div>--}}
                    {{--<div class="content">{{$archive['enrollyear']}}</div>--}}
                {{--</div>--}}
                <div class="row">
                    <div class="label">籍贯</div>
                    <div class="content">{{$archive['birthplace']}}</div>
                </div>
                <div class="row">
                    <div class="label">所在地</div>
                    <div class="content">{{$archive['location']}}</div>
                </div>

                <div class="list-box">
                    <h4 style="text-align: left">会员经历</h4>
                    <div>
                        @forelse($experience as $exp)
                            <div class="resume-li">
                                <a href="{{url('/mobile/member/experience/edit').'?id='.$exp['id']}}" class="iconfont icon-edit">编辑</a>
                                <div>{{$exp->year}} | @if($exp['vacation']=='0')寒假@else暑假@endif</div>
                                <div class="mainInfo">{{$exp->role}} · {{$exp->department}}</div>
                                <div>{{$exp->description}}</div>
                            </div>
                        @empty
                            <p class="notice">暂无会员经历</p>
                        @endforelse
                            <a href="{{url('/mobile/member/experience/add')}}" class="add-btn iconfont icon-add">添加会员经历</a>
                    </div>
                </div>

                <div class="list-box">
                    <h4>教育经历</h4>
                    <div>
                        @forelse ($edus as $edu)
                            <div class="resume-li">
                                <a href="{{url('/mobile/member/education?id='.$edu->id)}}" class="iconfont icon-edit">编辑</a>
                                <div>{{date('Y',$edu->start_time)}} - {{date('Y',$edu->end_time)}}</div>
                                <div class="mainInfo">{{$edu->school}}</div>
                                <div>
                                    @switch($edu->degree)
                                        @case('1')
                                        小学
                                        @break
                                        @case('2')
                                        初中
                                        @break
                                        @case('3')
                                        高中
                                        @break
                                        @case('4')
                                        专科
                                        @break
                                        @case('5')
                                        本科
                                        @break
                                        @case('6')
                                        硕士
                                        @break
                                        @case('7')
                                        博士
                                        @break
                                        @default
                                        其他
                                    @endswitch
                                    ·{{$edu->major}}
                                </div>
                            </div>
                        @empty
                            <p class="notice">暂无教育经历</p>
                        @endforelse
                        <a href="{{url('/mobile/member/education')}}" class="add-btn iconfont icon-add"> 添加</a>
                    </div>
                </div>

                <div class="list-box">
                    <h4>工作经历</h4>
                    <div>
                        @forelse($works as $work)
                            <div class="resume-li">
                                <a href="{{url('/mobile/member/work?id='.$work['id'])}}" class="iconfont icon-edit">编辑</a>
                                <div>{{date('Y-m-d',$work->start_time)}} - {{date('Y-m-d',$work->end_time)}}</div>
                                <div class="mainInfo">{{$work->job}}·{{$work->company}}</div>
                                <div>{{$work->experience}}</div>
                            </div>
                        @empty
                            <p class="notice">暂无工作经历</p>
                        @endforelse
                        <a href="{{url('/mobile/member/work')}}" class="add-btn iconfont icon-add"> 添加</a>
                    </div>
                </div>

                <div class="row">
                    <div class="label">会员等级</div>
                    <div class="content">@if($archive['post']){{$archive['post']}}@else普通会员@endif</div>
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
