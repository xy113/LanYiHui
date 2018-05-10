@extends('layouts.mobile')

@section('title', '我的投递')

@section('content')
<div class="deliver-detail">
    <div class="deliver-company">
        <img src="{{$data['company']['company_logo']}}">
        <div>
            <div>{{ $data['job']['title'] }}</div>
            <div>{{ $data['job']['place'] }} · {{$data['company']['company_name']}}</div>
            <div>薪资范围：@switch($data['job']['salary'])
                    @case('1')
                        0-5k
                    @break
                    @case('2')
                    5-10k
                    @break
                    @case('3')
                    10-15k
                    @break
                    @case('4')
                    15-20k
                    @break
                    @case('5')
                    20-30k
                    @break
                    @case('6')
                    30k以上
                    @break
                @endswitch
            </div>
            <span class="time">{{date('m月d日',$data['created_at'])}}</span>
            <span class="iconfont icon-right"></span>
        </div>
    </div>
    <div class="deliver-status">
        当前状态【@switch($data['status'])
            @case('-1') 不合适 @break
            @case('0') 待查看 @break
            @case('1') 已查看 @break
            @case('2') 待沟通 @break
            @case('3') 已录取 @break
        @endswitch】
    </div>
    <div class="deliver-record flowTime">
        <div class="flowChart">
            <!--左侧轴-->
            <div class="flowChart-left">
                <!--虚线-->
                <div class="dashed"></div>
            </div>
            <!--右侧内容-->
            <div class="flowChart-right">
                <!--一个节点-->
                @if($data['status']==3)
                <div class="oneNode">
                    <!--左侧小球-->
                    @if($data['status'] == 3) <div class="check check-success  iconfont icon-check"> @else <div class="check iconfont icon-check"> @endif
                        </div>
                    <div class="tag-boder">
                        <div class="tag">
                        </div>
                    </div>
                    <!--右侧内容-->
                    <div class="NodeDetail">
                        <!--中-->
                        <div class="NodeDetail-content">
                            <p>通过面试</p>
                        </div>
                        <!--下-->
                        <div class="NodeDetail-footer">
                            <span>{{$date('Y-m-d h:m:s',$data['end_time'])}}</span>

                        </div>
                    </div>
                </div>
                @endif
                    @if($data['status']!='0'&&$data['status']!='1')
                <div class="oneNode">
                    <!--左侧小球-->
                    @if($data['status']==2)
                        <div class="check check-success iconfont icon-check">
                    @elseif($data['status']==-1)
                                <div class="check check-danger iconfont icon-close">
                    @endif
                    </div>
                    <div class="tag-boder">
                        <div class="tag">
                        </div>
                    </div>
                    <!--右侧内容-->
                    <div class="NodeDetail">
                        <!--中-->
                        <div class="NodeDetail-content">
                            @if($data['status']==2)
                                <p>等待沟通</p>
                                    @elseif($data['status']==-1)
                                <p>您可能不适合这份工作。</p>
                                            @endif
                        </div>
                        <!--下-->
                        <div class="NodeDetail-footer">
                            <span>{{date('Y-m-d h:m:s',$data['updated_at'])}}</span>

                        </div>
                    </div>
                </div>
                    @endif
                @if($data['status']!='0')
                <div class="oneNode">
                    <!--左侧小球-->
                    @if($data['status'] == '1') <div class="check check-success iconfont icon-check"> @else <div class="check iconfont icon-check"> @endif
                        </div>
                    <div class="tag-boder">
                        <div class="tag">
                        </div>
                    </div>
                    <!--右侧内容-->
                    <div class="NodeDetail">
                        <!--中-->
                        <div class="NodeDetail-content">
                            <p>对方已查看您的简历。</p>
                        </div>
                        <!--下-->
                        <div class="NodeDetail-footer">
                            <span>{{date('Y-m-d h:m:s',$data['read_at'])}}</span>

                        </div>
                    </div>
                </div>
                @endif
                <div class="oneNode">
                    <!--左侧小球-->
                    @if($data['status'] == '0') <div class="check check-success iconfont icon-check"> @else <div class="check iconfont icon-check"> @endif
                    </div>
                    <div class="tag-boder">
                        <div class="tag">
                        </div>
                    </div>
                    <!--右侧内容-->
                    <div class="NodeDetail">
                        <!--中-->
                        <div class="NodeDetail-content">
                            <p>投递成功</p>
                        </div>
                        <!--下-->
                        <div class="NodeDetail-footer">
                            <span>{{date('Y-m-d h:m:s',$data['created_at'])}}</span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
