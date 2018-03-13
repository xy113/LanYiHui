@extends('layouts.default')

@section('content')
    <div class="home">
        <div class="area">
            <div class="slide">
                <div class="swiper-div" style="padding-top: 445px;">
                    <div class="swiper" id="swiper">
                        <ul class="swiper-wrapper">
                            @foreach($focus_imgs as $img)
                                <li class="swiper-slide"><a href="{{$img['url']}}" target="_blank"><img src="{{image_url($img['image'])}}"></a></li>
                            @endforeach
                        </ul>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                (function(){
                    var swiper = new Swiper('#swiper',
                        {loop:true,pagination:'.swiper-pagination',autoplay:2500});
                })();
            </script>

            <div class="news-wrap">
                <div class="news">
                    <h3>联谊会公告</h3>
                    <ul>
                        @foreach($newslist as $aid=>$item)
                            <li><a href="{{post_url($item['aid'])}}" target="_blank">&bull; {{$item['title']}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="blank"></div>
                <div class="stat">
                    <div>
                        <img src="{{asset('images/common/0.jpg')}}" class="image">
                        <h3 class="title">盘州大学生联谊会</h3>
                    </div>
                    <ul>
                        <li>
                            <h3>{{$memberCount}}</h3>
                            <p>会员数</p>
                        </li>
                        <li>
                            <h3>{{$articleCount}}</h3>
                            <p>文章数</p>
                        </li>
                        <li>
                            <h3>1000</h3>
                            <p>职位数</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="blank"></div>
        <!--联谊会达人-->
        <div class="area">
            <div class="title-div">
                <a class="more">更多达人></a>
                <strong>联谊会达人</strong>
            </div>
            <div class="daren-wrap">
                <ul>
                    <li>
                        <div class="hd" >
                            <div class="bg bg-cover" style="background-image: url({{asset('images/cont/user_img1.jpg')}})">
                                <img src="{{avatar($uid)}}" class="avatar">
                            </div>
                            <div class="info">
                                <div class="name">贵州大师兄</div>
                                <div class="star"><span class="iconfont icon-favorfill"></span>9645</div>
                                <div class="university">中央名族大学</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="hd" >
                            <div class="bg bg-cover" style="background-image: url({{asset('images/cont/user_img2.jpg')}})">
                                <img src="{{avatar($uid)}}" class="avatar">
                            </div>
                            <div class="info">
                                <div class="name">贵州大师兄</div>
                                <div class="star"><span class="iconfont icon-favorfill"></span>9645</div>
                                <div class="university">中央名族大学</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="hd" >
                            <div class="bg bg-cover" style="background-image: url({{asset('images/cont/user_img3.jpg')}})">
                                <img src="{{avatar($uid)}}" class="avatar">
                            </div>
                            <div class="info">
                                <div class="name">贵州大师兄</div>
                                <div class="star"><span class="iconfont icon-favorfill"></span>9645</div>
                                <div class="university">中央名族大学</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="hd" >
                            <div class="bg bg-cover" style="background-image: url({{asset('images/cont/user_img4.jpg')}})">
                                <img src="{{avatar($uid)}}" class="avatar">
                            </div>
                            <div class="info">
                                <div class="name">贵州大师兄</div>
                                <div class="star"><span class="iconfont icon-favorfill"></span>9645</div>
                                <div class="university">中央名族大学</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="hd" >
                            <div class="bg bg-cover" style="background-image: url({{asset('images/cont/user_img5.jpg')}})">
                                <img src="{{avatar($uid)}}" class="avatar">
                            </div>
                            <div class="info">
                                <div class="name">贵州大师兄</div>
                                <div class="star"><span class="iconfont icon-favorfill"></span>9645</div>
                                <div class="university">中央名族大学</div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@stop
