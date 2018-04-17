@extends('layouts.mobile')

@section('title', $user->info->name)

@section('content')
    <div class="mine-header">
        <div class="content">
            <img src="{{avatar($uid)}}" class="avatar">
            <div class="name">{{$user->info->name}}</div>
        </div>
    </div>

    <div class="space-tabs">
        <ul id="tabs">
            <li class="active">校友留言板</li>
            @if($isMe)
            <li>未读消息</li>
            @endif
        </ul>
    </div>
    <div class="space-content" id="contents">
        <ul class="itemlist" style="display: block;">
            @foreach ($message as $item)
               <div>
                   <p>{{$item['content']}}</p>
                   <div>{{$item->visitor->username}} | {{$item->created_at}} | 回复{{$item->reply->count()}}</div>
               </div>
            @endforeach
        </ul>
        <ul class="itemlist">
            @foreach ($message as $item)
                <div>
                    <p>{{$item['content']}}</p>
                    <div>{{$item->visitor->username}} | {{$item->created_at}} | 回复{{$item->reply->count()}}</div>
                </div>
            @endforeach
        </ul>
    </div>
    <div class="bottom-bar">
        <div class="fixed le_message_box">
            <input type="text" class="le_message_input" value=""><button>留言</button>
        </div>
    </div>
    <script type="text/javascript">
        $("#tabs>li").on('click', function () {
            $(this).addClass('active').siblings().removeClass('active');
            $("#contents>ul").eq($(this).index()).show().siblings().hide();
        })

        function le_message(id) {

        }
    </script>
@stop
