@extends('layouts.mobile')

@section('content')
    <div class="swiper-div" style="padding-top: 60%;">
        <div class="swiper" id="swiper">
            <ul class="swiper-wrapper">
                @foreach($focus_imgs as $img)
                    <li class="swiper-slide"><a><img src="{{image_url($img['image'])}}"></a></li>
                @endforeach
            </ul>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <script type="text/javascript">
        (function(){
            var swiper = new Swiper('#swiper',
                {loop:true,pagination:'.swiper-pagination',autoplay:2500});
        })();
    </script>

    <div class="global-menus">
        <ul class="wrapper">
            <li data-link="/mobile/post/list?catid=15">
                <div class="image"><img src="{{asset('images/mobile/news.png')}}"></div>
                <div class="title">盘联新闻</div>
            </li>
            <li data-link="/mobile/recruit?catid=1">
                <div class="image"><img src="{{asset('images/mobile/zhaoxin.png')}}"></div>
                <div class="title">部门招新</div>
            </li>
            <li data-link="/mobile/recruit?catid=2">
                <div class="image"><img src="{{asset('images/mobile/zhaomu.png')}}"></div>
                <div class="title">活动招募</div>
            </li>
            <li data-link="{{url('/mobile/job/list')}}">
                <div class="image"><img src="{{asset('images/mobile/zhaopin.png')}}"></div>
                <div class="title">工作机会</div>
            </li>
            <li data-link="/mobile/join/index">
                <div class="image"><img src="{{asset('images/mobile/jiaru.png')}}"></div>
                <div class="title">加入联谊会</div>
            </li>
            <li data-link="/mobile/daren">
                <div class="image"><img src="{{asset('images/mobile/daren.png')}}"></div>
                <div class="title">联谊会达人</div>
            </li>
            <li data-link="/mobile/company">
                <div class="image"><img src="{{asset('images/mobile/hezuo.png')}}"></div>
                <div class="title">合作伙伴</div>
            </li>
            <li data-link="/mobile/pages/detail/51.html">
                <div class="image"><img src="{{asset('images/mobile/zuzhi.png')}}"></div>
                <div class="title">组织架构</div>
            </li>
        </ul>
    </div>

    <div class="content-div">
        <div class="title-div">最新动态</div>
        <ul class="article-list">
            @foreach($newslist as $item)
                <li class="item" data-link="{{post_mobile_url($item['aid'])}}">
                    <div class="image bg-cover lazyload" data-original="{{image_url($item['image'])}}"></div>
                    <div class="data">
                        <h3 class="title">{{substring($item['title'], 28)}}</h3>
                        <div class="info">
                            <span>{{$item['view_num']}}浏览</span>
                            <span>{{$item['comment_num']}}评</span>
                        </div>
                        <span class="created_at">{{date('m-d', $item['created_at'])}}</span>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="more-div">
            <a href="{{url('/mobile/post/list?catid=15')}}">更多动态</a>
        </div>
    </div>

    @include('mobile.tabbar', ['tab' => 'home']);
@stop
