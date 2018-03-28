@extends('layouts.mobile')

@section('title', $catlog['name'])

@section('content')
    <div class="recruit">
        <ul class="item-list">
            @foreach ($itemlist as $item)
                <li data-link="{{url('/mobile/recruit/detail/'.$item['id'].'.html')}}">
                    <div class="image bg-cover lazyload" data-original="{{image_url($item['image'])}}"></div>
                    <div class="title">{{$item['title']}}</div>
                    <div class="data">
                        <i>{{@date('Y-m-d', $item['created_at'])}}</i>
                        <span>招募人数:{{$item['num']}}</span>
                        <span>报名人数:{{$item['enrolment']}}</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@stop
