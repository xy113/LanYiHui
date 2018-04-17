@extends('layouts.mobile')

@section('title', '校友录')

@section('content')

    <div>
        <div class="schoolfellow">
            <h4>我的校友录</h4>
            @foreach($list as $item)
            <div class="list-item" s_id="{{$item['id']}}">
                {{$item['name']}} <span style="position: initial"> @switch($item->pivot->degree)
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
                    本科
                    @break

                    @case('5')
                    硕士
                    @break

                    @case('6')
                    博士
                    @break

                    @case('7')
                    专科
                    @break
                    @default
                    其他
                    @endswitch | {{$item->pivot->major}}</span>
                <span style="color: #67C23A;">已认证</span>
            </div>
            @endforeach
        </div>

        <div class="schoolfellow">
            <h4>申请中</h4>
            @foreach($apply as $item)
                <div class="list-item">
                    {{$item['name']}} <span style="position: initial"> @switch($item->pivot->degree)
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
                            本科
                            @break

                            @case('5')
                            硕士
                            @break

                            @case('6')
                            博士
                            @break

                            @case('7')
                            专科
                            @break
                            @default
                            其他
                        @endswitch | {{$item->pivot->major}}</span>
                    <span style="color: orangered">待审核</span>
                </div>
            @endforeach
        </div>
    </div>
    <div class="bottom-bar">
        <div class="fixed">
            <div class="topic-publish" data-link="{{url('/mobile/forum/schoolfellow/application')}}">申请</div>
        </div>
    </div>
<script type="text/javascript">
    $('.list-item').on('tap',function () {
        var id = this.getAttribute('s_id');
        if (id){
            window.location = '{{url('/mobile/forum/schoolfellow')}}'+'?id='+id;
        }
    })
</script>
@stop
