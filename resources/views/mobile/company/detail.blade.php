@extends('layouts.mobile')

@section('title', $company['company_name'])

@section('content')
    <div class="company-detail">
        <h2 class="title">{{$company['company_name']}}</h2>
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
        <div class="blank"></div>
        <div class="title-div"><span>在招职位</span></div>
        <ul class="jobs">
            @foreach($jobList as $item)
                <li data-link="{{url('/mobile/job/detail/'.$item['job_id'].'.html')}}">
                    <h3>{{$item['title']}}</h3>
                    <span>{{$salary_ranges[$item['salary']]}}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="bottom-bar">
        <div class="fixed">
            @if($collect=='1')
                <div class="btn" collect="{{$collect}}" onclick="collect(this)"><i class="iconfont icon-favorfill"></i>已收藏</div>
            @else
                <div class="btn" collect="{{$collect}}" onclick="collect(this)"><i class="iconfont icon-favor"></i>收藏</div>
            @endif
        </div>
    </div>
    <script>
        function collect(obj) {
            var method = 1
            if($(obj).attr('collect')==1){
                method = 0
            }
            $.ajax({
                type:'POST',
                url:'{{url('/mobile/favorite/collect')}}',
                dataType: 'json',
                data:{
                    id:{{$company['company_id']}},
                    type:'company',
                    title:'{{$company['company_name']}}',
                    img:'{{$company['company_logo']}}',
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
