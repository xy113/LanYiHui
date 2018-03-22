@extends('layouts.mobile')

@section('title', '加入联谊会')

@section('content')
    <div class="join">
        <h2 class="title">联谊会入会要求</h2>
        <div class="content">{!! nl2br(setting('membership_desc')) !!}</div>
        <div class="bottom-view">
            <a href="{{url('/mobile/join/enroll')}}" class="button">立即申请加入</a>
        </div>
    </div>
@stop
