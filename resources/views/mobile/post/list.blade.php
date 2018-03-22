@extends('layouts.mobile')

@section('title', '联谊会动态')

@section('content')
    <ul class="article-list">
        @foreach($itemlist as $item)
            <li class="item" data-link="{{post_mobile_url($item['aid'])}}">
                <div class="image bg-cover lazyload" data-original="{{image_url($item['image'])}}"></div>
                <div class="data">
                    <h3 class="title">{{substring($item['title'], 28)}}</h3>
                    <div class="info">
                        <span>{{$item['view_num']}}浏览</span>
                        <span>{{$item['comment_num']}}评</span>
                    </div>
                    <span class="created_at">{{date('m-d', $item['created_at'])}}</span>
                </div>
            </li>
        @endforeach
    </ul>
@stop
