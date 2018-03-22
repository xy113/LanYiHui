@extends('layouts.mobile')

@section('title', '职位列表')

@section('content')
    <div class="job-list-wrapper">
        <ul class="job-list">
            @foreach($itemlist as $item)
                <li data-link="{{action('Mobile\JobController@detail', ['job_id'=>$item['job_id']])}}">
                    <div class="image bg-cover lazyload" data-original="{{image_url($item['company_logo'])}}"></div>
                    <div class="data">
                        <h3>{{$item['title']}}</h3>
                        <div class="company">{{$item['company_name']}}</div>
                        <div class="attrs">
                            {{$item['place']}}
                        </div>
                        <span class="pubtime">{!! @date('m-d', $item['created_at']) !!}发布</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@stop
