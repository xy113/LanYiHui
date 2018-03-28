@extends('layouts.mobile')

@section('title', $archive['fullname'])

@section('content')
    <div class="mine-header">
        <div class="content">
            <img src="{{avatar($uid)}}" class="avatar">
            <div class="name">{{$archive['fullname']}}  <span style="font-size: 14px;">{{$archive['university']}}</span></div>
        </div>
    </div>

    <div>
        <ul>
            <li>学校：{{$archive['university']}}</li>
            <li>年份：{{$archive['enrollyear']}}</li>
            <li>专业：{{$archive['major']}}</li>
        </ul>
    </div>

    <div class="space-content">
        <h3 class="title">Ta的文章</h3>
        <ul class="artilelist">
            @foreach ($articlelist as $item)
                <li><a href="{{post_mobile_url($item['aid'])}}">{{$item['title']}}</a></li>
            @endforeach
        </ul>
    </div>
@stop
