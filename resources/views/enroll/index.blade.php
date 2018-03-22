@extends('layouts.default')

@section('title', '加入联谊会')

@section('content')
    <div class="recruit">
        <div class="area">
            <div class="page-content">
                <h1 class="title">盘州大学生联谊会入会要求</h1>
                <div class="content">
                    {!! nl2br(setting('membership_desc')) !!}
                </div>
                <div class="bottom">
                    <a href="/enroll/enroll" class="button">申请入会</a>
                </div>
            </div>
        </div>
    </div>
@stop
