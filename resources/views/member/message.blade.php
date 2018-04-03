@extends('layouts.member')

@section('title')
    系统提示
@stop

@section('content')
    <div class="console-title">
        <h2>系统提示</h2>
    </div>
    <div class="sysmessage" style="margin-top: 30px;">
        <h3 class="{{$type or 'success'}}">{{$msg or ''}}</h3>
        @if($autoredirect)
            <div class="tips">{!! trans('ui.auto_redirect') !!}</div>
        @else
            <div class="tips">{!! trans('ui.message_tips') !!}</div>
        @endif

        <div class="links">
            @if($links)
                @foreach($links as $link)
                    <a href="{{$link['url'] or ''}}" target="{{$link['target'] or ''}}">{{$link['text'] or ''}}</a>
                @endforeach
            @else
                <a href="{{$forward or ''}}">{{trans('common.go_back')}}</a>
                <a href="/">{{trans('common.go_home')}}</a>
            @endif
        </div>
    </div>
    @if($autoredirect)
        <script type="text/javascript">
            var second = 5;
            var timeid = setInterval(function(){
                second--;
                if(second<1){
                    clearTimeout(timeid);
                    window.location = '{{$forward or ''}}';
                }else {
                    $("#timer").text(second);
                }
            },1000);
        </script>
    @endif
@stop
