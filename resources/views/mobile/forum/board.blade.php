@extends('layouts.mobile')

@section('title', $board['title'])

@section('content')
    <div class="board-data">
        <div class="flex">
            <img src="{{image_url($board['icon'])}}" class="image">
            <div class="content">
                <h3>{{$board['title']}}</h3>
                <div class="stat">
                    <p><span>话题</span><i>{{$topicCount}}</i></p>
                    <p><span>回复</span><i>{{$messageCount}}</i></p>
                </div>
            </div>
        </div>
    </div>

    <div class="board-tabs">
        <ul>
            <li class="active">最新发布</li>
            <li>热门话题</li>
        </ul>
    </div>

    <div class="topiclist">
        <ul>
            @foreach ($topiclist as $topic)
                <li data-link="{{url('/mobile/forum/topic/'.$topic['tid'])}}">
                    <div class="head">
                        <img src="{{avatar($topic['uid'], 'small')}}" class="avatar">
                        <div class="username">{{$topic['username']}}</div>
                    </div>
                    <h3 class="title">{{$topic['title']}}</h3>
                    <div class="foot">
                        <span>{{$topic['replies']}}回复</span>
                        <span>{{$topic['views']}}浏览</span>
                        <i>{{@date('m-d H:i', $topic['created_at'])}}</i>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="bottom-bar">
        <div class="fixed">
            <div class="topic-publish" data-link="{{url('/mobile/forum/publish?boardid='.$boardid)}}">发表话题</div>
        </div>
    </div>
@stop
