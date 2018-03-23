@extends('layouts.mobile')

@section('title', '联谊会达人')

@section('content')
    <ul class="daren-list">
        @foreach ($itemlist as $item)
            <li data-link="/mobile/space/{{$item['uid']}}">
                <div class="image bg-cover lazyload" data-original="{{avatar($item['uid'], 'middle')}}"></div>
                <div class="data">
                    <h3>{{$item['fullname']}}</h3>
                    <div class="address">{{$item['university']}}</div>
                    <div class="stars">
                        <span class="iconfont icon-favorfill"></span>
                        <span class="n">{{$item['stars']}}</span>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@stop
