@extends('layouts.mobile')

@section('title', $job['title'])

@section('content')
    <div class="job-detail">
        <div class="basic">
            <h1>{{$job['title']}}</h1>
            <div class="attrs">
                <span class="money">{{$salary_ranges[$job['salary']]}}元/月</span>
                @foreach($welfares as $k=>$v)
                    <i>/{{$v}}</i>
                @endforeach
            </div>
        </div>

        <div class="desc">
            <h2 class="title">职位描述</h2>
            <div class="content">{!! nl2br($job['description']) !!}</div>
        </div>

        <div class="desc">
            <h2 class="title">公司简介</h2>
            <ul class="company-data">
                <li>
                    <span class="label">所在地</span>
                    <span class="text">{{$company['city']}} {{$company['district']}}</span>
                </li>
                <li>
                    <span class="label">联系人</span>
                    <span class="text">{{$company['contact']}}</span>
                </li>
                <li>
                    <span class="label">联系电话</span>
                    <span class="text">{{$company['tel']}}</span>
                </li>
                <li>
                    <span class="label">电子邮件</span>
                    <span class="text">{{$company['email']}}</span>
                </li>
            </ul>
            <div class="content">{!! $content['content'] !!}</div>
        </div>
    </div>
@stop
