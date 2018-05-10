@extends('layouts.mobile')

@section('title', $user->info->name)

@section('content')
    <div class="mine-header message-top">
        <div class="content">
            <div class="avatar-box">
                <img src="{{avatar($user->uid)}}">
                <div>{{$user->archive->fullname}}</div>
            </div>
            <div class="long-bar">
                <li>联谊会职务：@if($user->archive->post){{$user->archive->post}}@else普通会员@endif</li>
                <li>人气指数：
                    <span class="iconfont icon-favorfill" style="color: #cbb956;"></span>{{$user->archive->stars}}
                <li>认证状态：{{$verify_status[$user->archive->status]}}</li>
            </div>
        </div>
    </div>

    @if($isMe==false)
        <div class="list-box setting-box">
            <div class="title" onclick="showInfo(this)">
                <span>教育经历</span>
            </div>
            <div class="info-box">
                @forelse ($edus as $edu)
                    <div class="resume-li">
                        <div>{{date('Y',$edu->start_time)}} - {{date('Y',$edu->end_time)}} | @switch($edu['status'])
                                @case('-1')
                                <font class="text-error"> 未通过</font>
                                @break
                                @case('0')
                                <font class="text-info"> 审核中</font>
                                @break
                                @case('1')
                                <font class="warning"> 复核中</font>
                                @break
                                @case('2')
                                <font class="text-primary"> 已审核</font>
                                @break
                            @endswitch</div>
                        <div class="mainInfo">{{$edu->school}}</div>
                        <div>
                            @switch($edu->degree)
                                @case('1')
                                小学
                                @break
                                @case('2')
                                初中
                                @break
                                @case('3')
                                高中
                                @break
                                @case('4')
                                专科
                                @break
                                @case('5')
                                本科
                                @break
                                @case('6')
                                硕士
                                @break
                                @case('7')
                                博士
                                @break
                                @default
                                其他
                            @endswitch
                            ·{{$edu->major}}
                        </div>
                    </div>
                @empty
                    <p class="notice">暂无教育经历</p>
                @endforelse
            </div>
        </div>
    @endif

    <div class="setting-box">
        <div class="title">
            <span>校友留言板</span>
        </div>
    </div>
    <div class="space-content" id="contents">
        <ul class="itemlist" style="display: block;">
            @foreach ($message as $item)
               <div class="message_box">
                   <div class="visitor-box">
                       <img src="{{avatar($item->visitor->uid)}}" class="avatar">
                       <div class="name">{{$item->visitor->archive->fullname}}</div>
                   </div>
                   <div class="msg_content">{{$item->content}}</div>
                   <div style="clear: both"></div>
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
                           <div style="display: table-cell; vertical-align: middle">
                           <div class="visitor-box">
                               <img src="{{avatar($item->visitor->uid)}}" class="avatar"><i class="name">{{$item->visitor->archive->fullname}}</i>
                           </div>
                           <div class="msg_content">回复<i class="name">{{$item->reply->visitor->username}}</i>：{{$item['content']}}</div>
                           </div>
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
        @if($message->count()==0)
            <div v-if="items.length==0">
                <div class="icon-no-data"></div>
                <p class="icon-no-data-p">暂无留言</p>
            </div>
        @endif
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
        function showInfo(obj) {
            if($(obj).siblings('.info-box').css('max-height')=='2000px'){
                $(obj).siblings('.info-box').animate({'max-height':'2px'},function () {
                    $(obj).children('li').html('展开');
                });
            }else {
                $(obj).siblings('.info-box').animate({'max-height':'2000px'});
                $(obj).children('li').html('收起');
            }
        }
    </script>
@stop
