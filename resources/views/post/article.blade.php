@extends('layouts.default')

@section('title', $article['title'])

@section('content')
    <div class="area article">
        <div class="main-frame">
            <div class="article-content">
                <h1 class="title">{{$article['title']}}</h1>
                <div class="info">
                    <span>{{@date('Y年m月d日 H:i',$article['created_at'])}}</span>
                    <span>阅读:{{$article['view_num']}}</span>
                    <a>评论:({{$article['comment_num']}})</a>
                    <a favorite="true" data-id="{{$aid}}" data-type="article">收藏本文</a>
                </div>

                <div class="content">{!! $content['content'] !!}</div>
            </div>
        </div>

        <div class="right-frame">
            <div class="content">
                <h3 class="title">热点文章</h3>
                <ul>
                    @foreach($hotnews as $aid=>$item)
                        <li>
                            <a href="{{post_url($item['aid'])}}">
                                <img src="{{image_url($item['image'])}}">
                                <div class="tit">
                                    <p>{{substring($item['title'], 18)}}</p>
                                    <div class="views">{{$item['view_num']}}次阅读</div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop
