@extends('layouts.mobile')

@section('title', $recruit['title'])

@section('content')
    <div class="recruit">
        <h1 class="item-title">{{$recruit['title']}}</h1>
        <div class="item-data">
            <i>时间:{{@date('m-d H:i', $recruit['created_at'])}}</i>
            <span>招募人数:{{$recruit['num']}}</span>
            <span>报名人数:{{$recruit['enrolment']}}</span>
        </div>
        <div class="item-content">
            <div><img src="{{image_url($recruit['image'])}}"></div>
            {!! $recruit['content'] !!}
        </div>
    </div>
    <div class="bottom-bar">
        <div class="fixed">
            @if($collect=='1')
            <div class="btn-left" collect="{{$collect}}" onclick="cellect(this)"><i class="iconfont icon-favorfill"></i>已收藏</div>
            @else
                <div class="btn-left" collect="{{$collect}}" onclick="cellect(this)"><i class="iconfont icon-favor"></i>收藏</div>
            @endif
            <div class="btn-right" data-link="{{url('/mobile/recruit/enroll?recruit_id='.$recruit['id'])}}">投递简历</div>
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
                    id:{{$recruit['id']}},
                    type:'recruit',
                    title:'{{$recruit['title']}}',
                    img:'{{$recruit['image']}}',
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
