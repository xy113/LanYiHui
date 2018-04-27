@extends('layouts.mobile')

@section('title', $school.'校友')

@section('content')
    <ul class="daren-list">
        @foreach ($members as $item)
            <li data-link="/mobile/message?id={{$item->uid}}">
                <div class="image bg-cover lazyload" data-original="{{avatar($item->uid, 'middle')}}"></div>
                <div class="data">
                    <h3>{{$item->fullname}}</h3>
                    <div class="address">
                        {{$item->enrollyear}}级
                    </div>

                    <div class="address">
                      {{$item->major}}
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @include('mobile.tabbar', ['tab' => 'com'])
@stop
