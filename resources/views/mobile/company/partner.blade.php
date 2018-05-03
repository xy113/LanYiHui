@extends('layouts.mobile')

@section('title', '合作单位')

@section('content')
    <div class="top-select">
        <li class="active">合作伙伴</li>
        <li onclick="turnTo('{{url('/mobile/company')}}')">认证企业</li>
    </div>
    <ul class="company-list">
        @foreach ($itemlist as $item)
            <li data-link="/mobile/company/detail/{{$item['company_id']}}.html">
                <div class="image bg-cover lazyload" data-original="{{image_url($item['company_logo'])}}"></div>
                <div class="data">
                    <h3>{{$item['company_name']}}</h3>
                    <div class="address">{{$item['province']}} {{$item['city']}} {{$item['county']}}</div>
                    <div class="views">
                        <span class="iconfont icon-attention"></span>
                        <span>{{$item['view_num']}}</span>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @include('mobile.tabbar', ['tab' => 'home']);
    <script type="text/javascript">
        function turnTo(url) {
            window.location = url;
        }
    </script>
@stop
