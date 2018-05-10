@extends('layouts.mobile')

@section('title', $school.'校友')

@section('content')
    <ul class="daren-list">
        @foreach ($list as $item)
            <li style="position: relative" class="bottom_line" data-link="/mobile/message?id={{$item->uid}}">
                <div class="image bg-cover lazyload" data-original="{{avatar($item->uid, 'middle')}}"></div>
                <div class="data">
                    <h3>{{$item->archive->fullname}}</h3>
                    <div class="address">
                        {{date('Y-m-d',$item->start_time)}} - {{date('Y-m-d',$item->end_time)}}
                    </div>

                    <div class="address">
                        @switch($item['degree'])
                            @case('1')小学@break
                            @case('2')初中@break
                            @case('3')高中@break
                            @case('4')专科@break
                            @case('5')本科@break
                            @case('6')硕士@break
                            @case('7')博士@break
                            @default其他
                        @endswitch | {{$item->major}}
                    </div>
                </div>
                @if($item['status']==1)
                    <span class="list_bq warning">复核中</span>
                @endif
            </li>
        @endforeach
            @if($list->count()==0)
                <div v-if="items.length==0">
                    <div class="icon-no-data"></div>
                    <p class="icon-no-data-p" style="font-size: 14px">暂无校友</p>
                </div>
            @endif
    </ul>
    @include('mobile.tabbar', ['tab' => 'com'])
@stop
