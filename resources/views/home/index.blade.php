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
                            <h3>{{$jobCount}}</h3>
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
                    @foreach ($darenlist as $k=>$item)
                        <li>
                            <div class="hd" >
                                <div class="bg bg-cover" style="background-image: url({{asset('images/cont/user_img'.($k+1).'.jpg')}})">
                                    <img src="{{avatar($item['uid'])}}" class="avatar">
                                </div>
                                <div class="info">
                                    <div class="name">{{$item['username']}}</div>
                                    <div class="star"><span class="iconfont icon-favorfill"></span>9645</div>
                                    <div class="university">{{$item['university']}}</div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="blank"></div>
        <div class="area">
            <div class="title-div">
                <a class="more">更多职位></a>
                <strong>最新职位</strong>
            </div>
            <div class="job-wrapper">
                <ul class="job-list">
                    @foreach($jobList as $item)
                        <li>
                            <div class="box-left">
                                <h3 class="job-title"><a href="{{job_url($item['job_id'])}}" target="_blank">{{$item['title']}}</a></h3>
                                <span class="job-type">(@if($item['type']==1)全职@else 兼职 @endif)</span>
                                <div class="job-data">
                                    <span class="salary">{{$salary_ranges[$item['salary']]}}/月</span>
                                    @foreach($item['welfares'] as $k=>$v)
                                        <i>{{$v}}</i>
                                    @endforeach
                                </div>
                            </div>
                            <div class="box-right">
                                <div class="pubtime">{{@date('Y-m-d H:i', $item['created_at'])}}</div>
                                <div class="company">{{$item['company_name']}}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop
