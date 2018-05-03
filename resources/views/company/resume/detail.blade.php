@extends('layouts.company')

@section('content')
    <div class="page-header">
        <div class="console-title">
            <a href="javascript:history.back();" class="button float-right">返回列表</a>
            <h2>简历详情</h2>
        </div>
    </div>
    <div class="page-content">
        <div class="form-wrapper">
            {{--基本信息--}}
            <h2>{{$resume['title']}}</h2>
            <div class="resume_info">
                <div class="resume_tip">基本信息</div>
                <img src="{{avatar($resume['uid'])}}" class="resume_header">
                <h2>{{$resume['name']}}</h2>
                <table  cellpadding="0" cellspacing="0" class="resume_table">
                    <tbody>
                    <tr>
                        <td>@if($resume['gender']=='1')<i class="iconfont icon-male"> 男</i>@else<i class="iconfont icon-female"> 女</i> @endif</td>
                        <td>{{$resume['age']}}岁</td>
                        <td width="160px"> @if($resume['address'])现居于{{$resume['address']}}@endif 所在地未知</td>
                    </tr>
                    <tr>
                        <td>
                            @switch($resume['education'])
                                @case('1') 小学 @break
                                @case('2') 初中 @break
                                @case('3') 高中 @break
                                @case('4') 专科 @break
                                @case('5') 本科 @break
                                @case('6') 硕士 @break
                                @case('7') 博士 @break
                                @default 其他
                            @endswitch
                        </td>
                        <td>{{$resume['work_exp']}}年工作经验</td>
                    </tr>
                    <tr>
                        <td width="160px">
                            <i class="iconfont icon-mobile"> {{$resume['phone']}}</i>
                        </td>
                        <td width="160px">
                            <i class="iconfont icon-mail"> {{$resume['email']}}</i>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            {{--工作经历--}}
            <div class="resume_info">
                <div class="resume_tip">工作经历</div>
                {{--{{$resume->works()->count()}}--}}
                @if($resume->works()->count()==0)
                <p class="info">
                    -- 暂无工作经历 --
                </p>
                @else
                @foreach($resume->works as $work)
                    <div class="resume_item">
                        <h4>{{$work['company']}}<span>{{date('Y-m-d',$work['start_time'])}} - {{date('Y-m-d',$work['end_time'])}}</span></h4>
                        <p class="info">{{$work['job']}}</p>
                        <p>工作介绍：{{$work['experience']}}</p>
                    </div>
                @endforeach
                @endif
            </div>
            {{--教育经历--}}
            <div class="resume_info">
                <div class="resume_tip">教育经历</div>
                @if($resume->edus()->count()==0)
                    <p class="info">
                        -- 暂无工作经历 --
                    </p>
                @else
                    @foreach($resume->edus as $edu)
                        <div class="resume_item">
                            <h4>{{$edu['school']}}<span>{{date('Y-m-d',$edu['start_time'])}} - {{date('Y-m-d',$edu['end_time'])}}</span></h4>
                            <p class="info">{{$edu['major']}} | @switch($edu['degree'])
                                    @case('1') 小学 @break
                                    @case('2') 初中 @break
                                    @case('3') 高中 @break
                                    @case('4') 专科 @break
                                    @case('5') 本科 @break
                                    @case('6') 硕士 @break
                                    @case('7') 博士 @break
                                    @default 其他
                                @endswitch</p>
                        </div>
                    @endforeach
                @endif
            </div>
            {{--自我介绍--}}
            <div class="resume_info">
                <div class="resume_tip">自我介绍</div>
                <p style="text-align: left; line-height: 2.5rem; padding: 0.5rem 1rem">{{$resume['introduction']}}</p>
            </div>
            <div class="resume_deal">
                @if($record['status']=='0'||$record['status']=='1')
                <p>是否通过“{{$job['title']}}”岗位简历筛选，进一步沟通？</p>
                <button class="primary" onclick="resumeDeal('2')">通过</button>
                <button class="error" onclick="resumeDeal('-1')">拒绝</button>
                @else
                @switch($record['status'])
                    @case('-1')
                    <h3 class="error">已拒绝</h3>
                    @break
                        @case('2')
                        <h3 class="success">已通过筛选，请及时联系</h3>
                        @break
                @endswitch
                @endif
            </div>
        </div>
        <script type="text/javascript">
            function resumeDeal(status) {
                $.ajax({
                    type:'POST',
                    url:'{{url('/company/resume/deal')}}',
                    dataType: 'json',
                    data:{
                        id:{{$record['id']}},
                        status:status
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function (res) {
                        if(res.errcode==0){
                            DSXUI.success('操作成功',function () {
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
    </div>
@stop
