@extends('layouts.mobile')

@section('title', $article['title'])

@section('content')
    <div class="articel-detail">
        <section class="head">
            <h1>{{$article['title']}}</h1>
            <p style="float: right;">盘州大学生联谊会</p>
            <p>{{date('Y-m-d H:i:s', $article['created_at'])}}   |   浏览量 {{$article['view_num']}}</p>
        </section>
        <div class="body">
            <div class="content" id="content">{!! $content['content'] !!}</div>
        </div>
    </div>

    <div class="comment">
        <div class="title">
            <span>最新评论</span>
        </div>
        @if($commentCount>0)
        <div class="listview">
            @foreach($commentList as $comm)
            <div class="item">
                <img src="{!! avatar($comm['uid'], 'small') !!}" class="avatar">
                <div class="content">
                    <div class="likes" data-action="toggleLike" data-id="{{$comm['commid']}}">
                        <span>{{$comm['likes']}}</span>
                        <i class="iconfont">&#xe824;</i>
                    </div>
                    <div class="username">{{$comm['username']}}</div>
                    <p class="location">
                        <span>{{$comm['province']}}{{$comm['city']}}网友</span>
                        <span>{{date('Y-m-d H:i', $comm['created_at'])}}</span>
                    </p>
                    <p class="message">
                        {!! $comm['message'] !!}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="nocomment" style="padding: 30px 0;">
            <div class="icon"></div>
            <p>暂时没有人发布评论</p>
        </div>
        @endif
    </div>
@stop
