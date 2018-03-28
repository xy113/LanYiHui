@extends('layouts.mobile')

@section('title', $topic['title'])

@section('content')
    <div class="topic-message">
        <h1 class="title">{{$topic['title']}}</h1>
        <div class="data">
            <img src="{{avatar($topic['uid'])}}" class="avatar">
            <div class="content">
                <div class="username">{{$topic['username']}}</div>
                <div class="attrs">
                    <span>{{$topic['views']}}浏览</span>
                    <span>{{$topic['replies']}}回复</span>
                </div>
            </div>
        </div>
        <div class="message">{{$message['message']}}</div>
    </div>
    @if($replyCount > 0)
    <div class="blank"></div>
    <div class="topic-section-title">最新回复</div>
    <div class="topiclist">
        <ul>
            @foreach ($messagelist as $msg)
                <li>
                    <div class="head">
                        <img src="{{avatar($msg['uid'], 'small')}}" class="avatar">
                        <div class="username">{{$msg['username']}}</div>
                    </div>
                    <h3 class="message">{{$msg['message']}}</h3>
                    <div class="foot">
                        <span>{{@date('m-d H:i', $msg['created_at'])}}</span>
                        <i></i>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="blank"></div>
    <div class="topic-section-title">发表回复</div>
    <div class="topic-reply-wrapper">
        <div class="form-wrap">
            <form method="post" id="Form" action="{{url('/mobile/forum/reply')}}">
                {{csrf_field()}}
                <input type="hidden" name="tid" value="{{$topic['tid']}}">
                <input type="hidden" name="boardid" value="{{$topic['boardid']}}">
                <div class="form-group">
                    <div class="content">
                        <textarea class="textarea" name="message" id="message" placeholder="填写回复内容，不少于5个字"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="content"><button type="button" class="button" id="submit" style="width: 100%;">回复</button></div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        (function () {
            $("#submit").on('click', function () {
                var message = $.trim($("#message").val());
                if (message.length < 5) {
                    DSXUI.error('请填写回复内容，不少于5个字');
                    return false;
                }

                var spinner = null;
                $("#Form").ajaxSubmit({
                    dataType:'json',
                    beforeSend:function () {
                        spinner = DSXUI.showSpinner();
                    },
                    success:function (response) {
                        setTimeout(function () {
                            spinner.close();
                            if (response.errcode === 0) {
                                DSXUI.success('回复发布成功', function () {
                                    DSXUtil.reFresh();
                                });
                            }
                        }, 500);
                    }
                });
            })
        })();
    </script>
@stop
