@extends('layouts.mobile')

@section('title', '交流')

@section('content')
    <div class="swiper-div" style="padding-top: 60%;">
        <div class="swiper" id="swiper">
            <ul class="swiper-wrapper">
                @foreach($focus_imgs as $img)
                    <li class="swiper-slide"><a><img src="{{image_url($img['image'])}}"></a></li>
                @endforeach
            </ul>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <script type="text/javascript">
        (function(){
            var swiper = new Swiper('#swiper',
                {loop:true,pagination:'.swiper-pagination',autoplay:2500});
        })();
    </script>
    <div class="forum-menus">
        <ul class="wrapper">
            @foreach ($boardlist as $board)
                <li data-link="{{url('/mobile/forum/board/'.$board['boardid'])}}">
                    <div class="image"><img src="{{image_url($board['icon'])}}"></div>
                    <div class="title">{{$board['title']}}</div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="blank"></div>
    <div class="topic-section-title"><span>最新话题</span></div>
    <div class="topiclist">
        <ul>
            @foreach ($newtopics as $topic)
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
    @include('mobile.tabbar', ['tab' => 'com'])
@stop
