@extends('layouts.mobile')

@section('title', $resume['title'])

@section('content')
    <div class="mine-header2">
        <div class="content">
            <img src="{{avatar($member['uid'])}}" class="avatar">
            <div class="name">{{$resume['title']}}</div>
        </div>
    </div>
    <div class="setting-box">
        <div>
            <div class="title" onclick="showInfo(this)"><span>基本信息</span><li>查看</li></div>
            <div class="member-archive info-box" style="max-height:2000px">
                <ul>
                    <li><i class="iconfont icon-my"></i>姓名：{{$resume['name']}}</li>
                    <li>@if($resume['gender'])<i class="iconfont icon-male"></i>@else<i class="iconfont icon-female"></i>@endif性别：@if($resume['gender'])男@else女@endif</li>
                    <li><i class="iconfont icon-footprint"></i>年龄：{{$resume['age']}}</li>
                    <li><i class="iconfont icon-mobile"></i>电话：{{$resume['phone']}}</li>
                    <li><i class="iconfont icon-mail"></i>邮箱：{{$resume['email']}}</li>
                    <li><i class="iconfont icon-bangzhuzhongxin"></i>最高学历：@switch($resume->education)
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
                            本科
                            @break
                            @default
                            其他
                        @endswitch</li>
                    <li><i class="iconfont icon-punch"></i>工作经验：{{$resume['work_exp']}}</li>
                    <li><i class="iconfont icon-location"></i>所在地：{{$resume['address']}}</li>
                    <li><i class="iconfont icon-tag"></i>自我介绍：{!! $resume['introduction'] !!}</li>
                </ul>
            </div>
        </div>
        <div class="list-box">
            <div class="title" onclick="showInfo(this)"><span>教育经历</span><li>查看</li></div>
            <div class="info-box">
                @forelse ($edus as $edu)
                    <div class="resume-li">
                        <div>{{date('Y',$edu->start_time)}} - {{date('Y',$edu->end_time)}} | @switch($edu['status'])
                                @case('-1')
                                <font class="text-error"> 未通过</font>
                                @break
                                @case('0')
                                <font class="text-info"> 审核中</font>
                                @break
                                @case('1')
                                <font class="warning"> 复核中</font>
                                @break
                                @case('2')
                                <font class="text-primary"> 已审核</font>
                                @break
                            @endswitch</div>
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
            </div>
        </div>

        <div class="list-box">
            <div class="title" onclick="showInfo(this)"><span>工作经历</span><li>查看</li></div>
            <div class="info-box">
                @forelse($works as $work)
                    <div class="resume-li">
                        <div>{{date('Y-m-d',$work->start_time)}} - {{date('Y-m-d',$work->end_time)}} | @switch($work['status'])
                                @case('-1')
                                <font class="text-error"> 未通过</font>
                                @break
                                @case('0')
                                <font class="text-info"> 审核中</font>
                                @break
                                @case('1')
                                <font class="warning"> 复核中</font>
                                @break
                                @case('2')
                                <font class="text-primary"> 已审核</font>
                                @break
                            @endswitch</div>
                        <div class="mainInfo">{{$work->job}}·{{$work->company}}</div>
                        <div>{{$work->experience}}</div>
                    </div>
                @empty
                    <p class="notice">暂无工作经历</p>
                @endforelse
            </div>
        </div>
    </div>
    <script>
        function showInfo(obj) {
            if($(obj).siblings('.info-box').css('max-height')=='2000px'){
                $(obj).siblings('.info-box').animate({'max-height':'2px'},function () {
                    $(obj).children('li').html('展开');
                });
            }else {
                $(obj).siblings('.info-box').animate({'max-height':'2000px'});
                $(obj).children('li').html('收起');
            }
        }
    </script>
@stop
