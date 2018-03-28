@extends('layouts.mobile')

@section('title', $recruit['title'])

@section('content')
    <div class="recruit">
        <h1 class="item-title">{{$recruit['title']}}</h1>
        <div class="item-data">
            <i>时间:{{@date('m-d H:i', $recruit['created_at'])}}</i>
            <span>招募人数:{{$recruit['num']}}</span>
            <span>报名人数:{{$recruit['enrolment']}}</span>
        </div>
        <div class="item-content">
            <div><img src="{{image_url($recruit['image'])}}"></div>
            {!! $recruit['content'] !!}
        </div>
    </div>
    <div class="bottom-bar">
        <div class="fixed">
            <div class="btn" data-link="{{url('/mobile/recruit/enroll?recruit_id='.$recruit['id'])}}">投递简历</div>
        </div>
    </div>
@stop
