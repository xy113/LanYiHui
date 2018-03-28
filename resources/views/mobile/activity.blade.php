@extends('layouts.mobile')

@section('title', '近期活动')

@section('content')
    <div class="content-div">
        <ul class="activity-list">
            @foreach($itemlist as $item)
                <li class="item" data-link="{{post_mobile_url($item['aid'])}}">
                    <div class="data">
                        <h3 class="title">{{substring($item['title'], 28)}}</h3>
                        <div class="info">
                            <span>{{$item['view_num']}}浏览</span>
                            <span>{{$item['comment_num']}}评</span>
                        </div>
                        <span class="created_at">{{date('m-d', $item['created_at'])}}</span>
                    </div>
                    <div class="image bg-cover lazyload" data-original="{{image_url($item['image'])}}"></div>
                </li>
            @endforeach
        </ul>
    </div>
    @include('mobile.tabbar', ['tab' => 'grow'])
@stop
