@extends('layouts.mobile')

@section('title', '会员档案')

@section('content')
    <div class="mine-header2">
        <div class="content">
            <img src="{{avatar($member['uid'])}}" class="avatar">
            <div class="name">{{$member->archive['fullname']}}</div>
        </div>
    </div>
    @if($archive)
        <div class="user-info">
            <div class="row">
                <div class="label">会员等级:</div>
                <div class="content">@if($archive['post']){{$archive['post']}}@else普通会员@endif</div>
            </div>
            <div class="row">
                <div class="label">人气指数:</div>
                <div class="content"><span class="iconfont icon-favorfill" style="color: #cbb956;"></span>{{$archive['stars']}}</div>
            </div>

            <div class="row">
                <div class="label">认证状态:</div>
                <div class="content">{{$verify_status[$archive['status']]}}</div>
            </div>
        </div>
    <div class="setting-box">
        <div>
            <div class="title" onclick="showInfo(this)"><span>基本信息</span><li>查看</li></div>
            <div class="member-archive info-box">
                <i class="edit-link iconfont icon-edit"  data-link="{{url('/mobile/member/edit')}}">修改</i>
                <ul>
                    <li><i class="iconfont icon-vip"></i>会员ID：{{$archive['id']}}</li>
                    <li><i class="iconfont icon-people"></i>姓名：{{$archive['fullname']}}</li>
                    <li>@if($archive['sex'])<i class="iconfont icon-male"></i>@else<i class="iconfont icon-female"></i>@endif性别：@if($archive['sex'])男@else女@endif</li>
                    <li><i class="iconfont icon-global"></i>籍贯：{{$archive['birthplace']}}</li>
                    <li><i class="iconfont icon-location"></i>所在地：{{$archive['location']}}</li>
                    <li><i class="iconfont icon-evaluate"></i>出生日期：{{$archive['birthday']}}</li>
                    <li><i class="iconfont icon-mobile"></i>电话：{{$archive['phone']}}</li>
                </ul>
            </div>
        </div>
        <div class="list-box">
            <div class="title" onclick="showInfo(this)"><span>会员经历</span><li>查看</li></div>
            <div class="info-box">
                @forelse($experience as $exp)
                    <div class="resume-li">
                        <a href="{{url('/mobile/member/experience/edit').'?id='.$exp['id']}}" class="iconfont icon-edit" style="right: 3.5rem;">编辑</a>
                        <a onclick="deleteWithType('experience',{{$exp['id']}},this)" class="iconfont icon-delete text-error">删除</a>
                        <div> {{$exp->year}} | @if($exp['vacation']=='0')寒假@else暑假@endif | @switch($exp['status'])
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
                        <div class="mainInfo">{{$exp->role}} · {{$exp->department}}</div>
                        <div>{{$exp->description}}</div>
                    </div>
                @empty
                    <p class="notice">暂无会员经历</p>
                @endforelse
                <a href="{{url('/mobile/member/experience/add')}}" class="add-btn iconfont icon-add">添加会员经历</a>
            </div>
        </div>

        <div class="list-box">
            <div class="title" onclick="showInfo(this)"><span>教育经历</span><li>查看</li></div>
            <div class="info-box">
                @forelse ($edus as $edu)
                    <div class="resume-li">
                        <a href="{{url('/mobile/member/education?id='.$edu->id)}}" class="iconfont icon-edit" style="right: 3.5rem">编辑</a>
                        <a onclick="deleteWithType('education',{{$edu['id']}},this)" class="iconfont icon-delete text-error">删除</a>
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
                <a href="{{url('/mobile/member/education')}}" class="add-btn iconfont icon-add"> 添加</a>
            </div>
        </div>

        <div class="list-box">
            <div class="title" onclick="showInfo(this)"><span>工作经历</span><li>查看</li></div>
            <div class="info-box">
                @forelse($works as $work)
                    <div class="resume-li">
                        <a href="{{url('/mobile/member/work?id='.$work['id'])}}" class="iconfont icon-edit" style="right: 3.5rem">编辑</a>
                        <a onclick="deleteWithType('work',{{$work['id']}},this)" class="iconfont icon-delete text-error">删除</a>
                        <div>{{date('Y-m-d',$work->start_time)}} - {{date('Y-m-d',$work->end_time)}} | @switch($work['status'])
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
                        <div class="mainInfo">{{$work->job}}·{{$work->company}}</div>
                        <div>{{$work->experience}}</div>
                    </div>
                @empty
                    <p class="notice">暂无工作经历</p>
                @endforelse
                <a href="{{url('/mobile/member/work')}}" class="add-btn iconfont icon-add"> 添加</a>
            </div>
        </div>
    </div>
    @else
        <div class="noaccess">你还不是联谊会会员</div>
        <div class="join-btn"><a href="{{url('/mobile/join/index')}}" class="button">立即申请加入</a></div>
    @endif
    @include('mobile.tabbar', ['tab' => 'mine'])
    {{--<script type="text/javascript" src="{{asset('js/jquery.cookie.js')}}"></script>--}}
    <script type="text/javascript" src="{{asset('layer/layer.js')}}"></script>
    <script type="text/javascript">
        function deleteWithType(type,id,obj) {
            layer.confirm('是否确认删除该记录？',{
                title:'提示',
                btn: ['确认','取消'] //按钮
            }, function(){
                $.ajax({
                    type:'GET',
                    url:'{{url('/mobile/member/deleteWithType')}}',
                    dataType: 'json',
                    data:{
                        id:id,
                        type:type,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function (res) {
                        if (res.errcode == 0){
                            DSXUtil.reFresh();
                        }
                    },
                    error:function (err) {
                        alert('修改失败，请稍后重试！');
                    }
                })
            }, function(){
            });
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
