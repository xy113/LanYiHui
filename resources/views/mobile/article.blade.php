@extends('layouts.mobile')

@section('title', $article['title'])

@section('content')
    <div class="articel-detail">
        <section class="head">
            <h1>{{$article['title']}}</h1>
            <p style="float: right;">盘州大学生联谊会</p>
            <p>{{date('Y-m-d H:i:s', $article['created_at'])}}   |   浏览量 {{$article['view_num']}}</p>
        </section>
        <div class="post-top">作者：@if($article['author']){{$article['author']}}@else佚名@endif
            @if($collect=='1')
                <span class="" collect="{{$collect}}" onclick="favorite(this)"><i class="iconfont icon-favorfill"></i>已收藏</span>
            @else
                <span collect="{{$collect}}" onclick="favorite(this)"><i class="iconfont icon-favor"></i>收藏</span>
            @endif
        </div>
        <div class="body">
            <div class="content" id="content">{!! $content['content'] !!}</div>
        </div>
    </div>

    <div class="comment">
        <div class="title">
            <span>最新评论</span>
        </div>
        @if($commentCount>0)
        <div class="listview">
            @foreach($commentList as $comm)
            <div class="item">
                <img src="{!! avatar($comm['uid'], 'small') !!}" class="avatar">
                <div class="content">
                    <div class="likes" data-action="toggleLike" data-id="{{$comm['commid']}}">
                        <span>{{$comm['likes']}}</span>
                        <i class="iconfont">&#xe824;</i>
                    </div>
                    <div class="username">{{$comm['username']}}</div>
                    <p class="location">
                        <span>{{$comm['province']}}{{$comm['city']}}网友</span>
                        <span>{{date('Y-m-d H:i', $comm['created_at'])}}</span>
                    </p>
                    <p class="message">
                        {!! $comm['message'] !!}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="nocomment" style="padding: 30px 0;">
            <div class="icon"></div>
            <p>暂时没有人发布评论</p>
        </div>
        @endif
        <div class="bottom-bar">
            <div class="fixed le_message_box">
                <input type="text" class="le_message_input" value=""><button onclick="le_message(this)">留言</button>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.3.2.js"></script>
    <script>
        function le_message(obj) {
            $.ajax({
                type:'POST',
                url:'{{url('/mobile/post/message')}}',
                dataType: 'json',
                data:{
                    id:{{$article['aid']}},
                    message:$(obj).prev().val(),
                    reply_uid:0,
                    reply_name:''
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function (res) {
                    if(res.errcode==0){
                        DSXUI.success('发表成功',function () {
                            DSXUtil.reFresh()
                        })
                    }else {
                        DSXUI.error(res.msg);
                    }
                },
                error:function (err) {
                }
            })
        }

        function favorite(obj) {
            var method = 1;
            if($(obj).attr('collect')==1){
                method = 0
            }
            wx.miniProgram.postMessage({ data: '{{$aid}}' });
            $.ajax({
                type:'POST',
                url:'{{url('/mobile/favorite/collect')}}',
                dataType: 'json',
                data:{
                    id:{{$article['aid']}},
                    type:'article',
                    title:'{{$article['title']}}',
                    img:'{{$article['image']}}',
                    method:method
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function (res) {
                    if(res.errcode==0){
                        DSXUtil.reFresh()
                    }else if(res.errcode===1){
                        DSXUI.error(res.msg);
                    }else{
                        DSXUI.error(res.msg);
                    }
                },
                error:function (err) {

                }
            })
        }
    </script>
@stop
