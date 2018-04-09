@extends('layouts.mobile')

@section('title', '')

@section('content')
    <div class="resume">
        <div class="resume-detail">
            <div class="row">
                <div class="label">姓名</div>
                <div class="content">{{$resume['name']}}</div>
            </div>
            <div class="row">
                <div class="label">性别</div>
                <div class="content">@if($resume['gender'])男@else女@endif</div>
            </div>
            <div class="row">
                <div class="label">年龄</div>
                <div class="content">{{$resume['age']}}</div>
            </div>
            <div class="row">
                <div class="label">电话</div>
                <div class="content">{{$resume['phone']}}</div>
            </div>
            <div class="row">
                <div class="label">邮箱</div>
                <div class="content">{{$resume['email']}}</div>
            </div>
            <div class="row">
                <div class="label">最高学历</div>
                <div class="content">{{$resume['education']}}</div>
            </div>
            <div class="row">
                <div class="label">工作经验</div>
                <div class="content">{{$resume['work_exp']}}年</div>
            </div>
            <div class="row">
                <div class="label">个人介绍</div>
                <div class="content">{!! $resume['introduction'] !!}</div>
            </div>
            <div class="list-box">
                <h4>教育经历</h4>
                <div>
                    @forelse ($edus as $edu)
                        <div class="resume-li">
                            <div>{{$edu->end_time}}年毕业</div>
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
                                    本科
                                    @break
                                    @case('5')
                                    硕士
                                    @break
                                    @case('6')
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
                <h4>工作经历</h4>
                <div>
                    @forelse($works as $work)
                        <div class="resume-li">
                            <div>{{$work->start_time}} - {{$work->end_time}}</div>
                            <div class="mainInfo">{{$work->job}}·{{$work->company}}</div>
                            <div>{{$work->experience}}</div>
                        </div>
                    @empty
                        <p class="notice">暂无工作经历</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@stop
