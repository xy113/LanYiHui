@extends('layouts.default')

@section('title', $job['title'])

@section('content')
    <div class="area job">
        <div class="page-content">
            <div class="content">
                <div class="job-top-msg">
                    <span class="job-title">{{$job['title']}}</span>
                    <span class="job-type">(@if($job['type']==1)全职@else兼职@endif)</span>
                    <span class="job-salary">{{$salary_ranges[$job['salary']]}}元/月</span>
                </div>
                <div class="job-data">
                    <span>地点: {{$job['place']}}</span>
                    <span>招聘人数: {{$job['num']}}人</span>
                    <span>发布于: {{date('Y-m-d H:i', $job['created_at'])}}</span>
                </div>
                <ul class="welfares">
                    @foreach($job['welfare'] as $k=>$v)
                        <li>{{$v}}</li>
                    @endforeach
                </ul>

                <div class="job-data-title">职位描述</div>
                <div class="job-desc">{!! nl2br($job['description']) !!}</div>

                <div class="job-data-title">工作地点</div>
                <div class="job-desc">{{$job['place']}} {{$company['company_name']}}</div>
            </div>
        </div>

        <div class="page-right">
            <div class="content">
                <div class="company-image">
                    <img src="{{image_url($company['company_logo'])}}">
                </div>
                <div class="company-name">{{$company['company_name']}}</div>

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

                <div class="data-title">公司简介</div>
                <div class="company-content">{!! $content['content'] or ''!!}</div>
            </div>
        </div>
    </div>
@stop
