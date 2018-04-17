@extends('layouts.mobile')

@section('title', $school['name'].'校友')

@section('content')
    <ul class="daren-list">
        @foreach ($members as $item)
            <li data-link="/mobile/message?id={{$item->user->uid}}">
                <div class="image bg-cover lazyload" data-original="{{avatar($item->user->uid, 'middle')}}"></div>
                <div class="data">
                    <h3>{{$item->user->info->name}}</h3>
                    <div class="address">
                        {{$item->graduation_at}}毕业
                    </div>
                    <div class="address">
                        @switch($item->degree)
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
                        @endswitch | {{$item->major}}
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @include('mobile.tabbar', ['tab' => 'com'])
@stop
