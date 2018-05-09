@extends('layouts.mobile')

@section('title', '校友录')

@section('content')

    <div>
        <div class="schoolfellow">
            <h4>我的校友录</h4>
            @foreach($list1 as $item)
                <div class="list-item bottom_line" s_name="{{$item['school']}}">
                    {{$item['school']}} <span style="position: initial">已入驻：{{$item['count']}}人次</span>
                    <span style="color: #67C23A;">已认证</span>
                </div>
            @endforeach
            @foreach($list2 as $item)
                <div class="list-item bottom_line" s_name="{{$item['school']}}">
                    {{$item['school']}} <span style="position: initial">已入驻：{{$item['count']}}人次</span>
                    <span style="color: #E6A23C;">复核中</span>
                </div>
            @endforeach
        </div>
    </div>
    @include('mobile.tabbar', ['tab' => 'mine'])
    <script type="text/javascript">
        $('.list-item').on('tap',function () {
            var name = this.getAttribute('s_name');
            if (name){
                window.location = '{{url('/mobile/schoolfellow/list')}}'+'?school='+name;
            }
        })
    </script>
@stop
