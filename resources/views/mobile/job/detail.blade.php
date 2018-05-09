@extends('layouts.mobile')

@section('title', $job['title'])

@section('content')
    <div class="job-detail">
        <div class="basic">
            <h1>{{$job['title']}}</h1>
            <div class="attrs">
                <span class="money">{{$salary_ranges[$job['salary']]}}元/月</span>
                @foreach($welfares as $k=>$v)
                    <i>/{{$v}}</i>
                @endforeach
            </div>
        </div>

        <div class="desc">
            <h2 class="title">职位描述</h2>
            <div class="content">{!! nl2br($job['description']) !!}</div>
        </div>

        <div class="desc">
            <h2 class="title">公司简介</h2>
            <ul class="company-data">
                <li>
                    <span class="label">所在地</span>
                    <span class="text">{{$company['city']}} {{$company['district']}}</span>
                </li>
                <li>
                    <span class="label">联系人</span>
                    <span class="text">{{$company['contact']}}</span>
                </li>
                <li>
                    <span class="label">联系电话</span>
                    <span class="text">{{$company['tel']}}</span>
                </li>
                <li>
                    <span class="label">电子邮件</span>
                    <span class="text">{{$company['email']}}</span>
                </li>
            </ul>
            <div class="content">{!! $content['content'] !!}</div>
        </div>
    </div>
    <div class="bottom-bar">
        <div class="fixed">
            @if($collect=='1')
                <div class="btn-left" collect="{{$collect}}" onclick="cellect(this)"><i class="iconfont icon-favorfill"></i>已收藏</div>
            @else
                <div class="btn-left" collect="{{$collect}}" onclick="cellect(this)"><i class="iconfont icon-favor"></i>收藏</div>
            @endif
            <div class="btn-right" data-link="{{url('/mobile/job/enroll?job_id='.$job['job_id'])}}">投递简历</div>
        </div>
    </div>
    <script>
        function cellect(obj) {
            var method = 1
            if($(obj).attr('collect')==1){
                method = 0
            }
            $.ajax({
                type:'POST',
                url:'{{url('/mobile/favorite/collect')}}',
                dataType: 'json',
                data:{
                    id:{{$job['job_id']}},
                    type:'job',
                    title:'{{$job['title']}}',
                    img:'{{$job['place']}}',
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
