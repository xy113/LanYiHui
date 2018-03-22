@extends('layouts.default')

@section('title', '招聘')

@section('content')
    <div class="recruit">
        <div class="area">
            <div class="page-content">
                <h1 class="title">联谊会入会要求</h1>
                <div class="content">
                    {!! nl2br(setting('membership_desc')) !!}
                </div>
                <div class="bottom">
                    <a class="button">立即申请加入</a>
                </div>
            </div>
        </div>
    </div>
@stop
