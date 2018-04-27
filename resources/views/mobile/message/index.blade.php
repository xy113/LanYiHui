@extends('layouts.mobile')

@section('title', $user->info->name)

@section('content')
    <div class="mine-header">
        <div class="content">
            <img src="{{avatar($user->uid)}}" class="avatar">
            <div class="name">{{$user->archive->fullname}}</div>
        </div>
    </div>

    <div class="space-tabs">
        <ul>
            <li>校友留言板</li>
        </ul>
    </div>
    <div class="space-content" id="contents">
        <ul class="itemlist" style="display: block;">
            @foreach ($message as $item)
               <div class="message_box">
                   <img src="{{avatar($item->visitor->uid)}}" class="avatar"><i class="name">{{$item->visitor->archive->fullname}}</i>
                   <div class="msg_content">{{$item->content}}</div>
                   <div>
                       <span onclick="showReply(this)">查看回复</span>
                       ({{$item->children->count()}})
                       @if($item->vid==$uid)
                           <span class="del_btn" onclick="del({{$item->id}},this)"> 删除 </span>
                           @else
                           <span class="msg_btn" onclick="showInput(this)"> 回复 </span>
                       @endif
                       <span class="time">{{$item->created_at}}</span>
                   </div>
                   <div class="replys">
                   @foreach($item->children as $item)
                       <div class="reply_box">
                           <img src="{{avatar($item->visitor->uid)}}" class="avatar"><i class="name">{{$item->visitor->archive->fullname}}</i>
                           <div class="msg_content">回复<i class="name">{{$item->reply->visitor->username}}</i>：{{$item['content']}}</div>
                           <div>
                               @if($item->vid==$uid)
                                   <span class="del_btn" onclick="del({{$item->id}},this)"> 删除 </span>
                                   @else
                                   <span class="msg_btn" onclick="showInput(this)">回复</span>
                               @endif
                                   <span class="time">{{$item->created_at}}</span>
                           </div>
                           <div></div>

                           <div class="le_message_box reply-box" style="display: none">
                               <input type="text" class="le_message_input" value=""><button onclick="le_message({{$item->id}},this,{{$item->vid}})">回复</button>
                           </div>
                       </div>
                   @endforeach
                   </div>
                   <div class="le_message_box reply-box" style="display: none">
                       <input type="text" class="le_message_input" value=""><button onclick="le_message({{$item->id}},this,{{$item->vid}})">回复</button>
                   </div>
               </div>
            @endforeach
        </ul>
    </div>
    @if($isMe==false)
    <div class="bottom-bar">
        <div class="fixed le_message_box">
            <input type="text" class="le_message_input" value=""><button onclick="le_message(0,this,{{$user->uid}})">留言</button>
        </div>
    </div>
    @endif
    <script type="text/javascript">
        $("#tabs>li").on('click', function () {
            $(this).addClass('active').siblings().removeClass('active');
            $("#contents>ul").eq($(this).index()).show().siblings().hide();
        })
        
        function showInput(obj) {
            var msg = $(obj).parent().siblings('.reply-box');
            if (msg.css('display')=='none'){
                $(".reply-box").hide();
                msg.css('display','block');
            }else {
                msg.css('display','none');
            }
        }
        function showReply(obj) {
            var reply = $(obj).parent().siblings('.replys');
            if(reply.css('display')=='none'){
                $(".replys").hide();
                reply.css('display','block');
                $(obj).html('收起');
            }else {
                reply.css('display','none');
                $(obj).html('查看');
            }
        }
        function le_message(id,obj,to_id) {
            var level = 1;
            if (id){
                level = 0;
            }
            console.log($(obj).siblings('.le_message_input').val());
//            return false;
            $.ajax({
                type:'POST',
                url:'{{url('/mobile/leaveMessage')}}',
                dataType: 'json',
                data:{
                    uid:to_id,
                    content:$(obj).prev().val(),
                    reply_id:id,
                    level:level
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
        function del(id,obj) {
            console.log(id,obj);
            $.ajax({
                type:'POST',
                url:'{{url('/mobile/message/del')}}',
                dataType: 'json',
                data:{
                    id:id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function (res) {
                    if(res.errcode==0){
                        $(obj).parent().parent().remove();
                        DSXUI.success('删除成功',function () {
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
    </script>
@stop
