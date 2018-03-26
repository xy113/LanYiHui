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
                <div class="label">毕业学校</div>
                <div class="content">{{$resume['university']}}</div>
            </div>
            <div class="row">
                <div class="label">毕业年份</div>
                <div class="content">{{$resume['graduation_year']}}</div>
            </div>
            <div class="row">
                <div class="label">最高学历</div>
                <div class="content">{{$resume['education']}}</div>
            </div>
            <div class="row">
                <div class="label">所学专业</div>
                <div class="content">{{$resume['major']}}</div>
            </div>
            <div class="row">
                <div class="label">工作经验</div>
                <div class="content">{{$resume['work_exp']}}年</div>
            </div>
            <div class="row">
                <div class="label">工作经历</div>
                <div class="content">{!! $resume['work_history'] !!}</div>
            </div>
            <div class="row">
                <div class="label">个人介绍</div>
                <div class="content">{!! $resume['introduction'] !!}</div>
            </div>
        </div>
    </div>
@stop
