@extends('layouts.mobile')

@section('title', $archive['fullname'])

@section('content')
    <div class="mine-header">
        <div class="content">
            <img src="{{avatar($uid)}}" class="avatar">
            <div class="name">{{$archive['fullname']}}  <span style="font-size: 14px;">{{$archive['university']}}</span></div>
        </div>
    </div>

    <div class="space-tabs">
        <ul id="tabs">
            <li class="active">Ta的文章</li>
            <li>Ta的话题</li>
        </ul>
    </div>
    <div class="space-content" id="contents">
        <ul class="itemlist" style="display: block;">
            @foreach ($articlelist as $item)
                <li data-link="{{post_mobile_url($item['aid'])}}">{{$item['title']}}</li>
            @endforeach
        </ul>
        <ul class="itemlist">
            @foreach ($topiclist as $item)
                <li data-link="{{url('mobile/forum/topic/'.$item['tid'])}}">{{$item['title']}}</li>
            @endforeach
        </ul>
    </div>
    <script type="text/javascript">
        $("#tabs>li").on('click', function () {
            $(this).addClass('active').siblings().removeClass('active');
            $("#contents>ul").eq($(this).index()).show().siblings().hide();
        })
    </script>
@stop
