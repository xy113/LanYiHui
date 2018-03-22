@extends('layouts.default')

@section('title', '人才库')

@section('content')
    <div class="area job">
        <div class="search-wrapper">
            <form method="get">
                <div class="keywords">
                    <input type="text" class="s-text" placeholder="实习生" name="q" value="{{$q or ''}}">
                </div>
                <input type="submit" class="s-button" value="搜索">
                <div class="r-search">
                    <span>相关搜索：</span>
                    <div class="words">
                        <a href="/job?q=实习生">实习生</a>
                        <a href="/job?q=行政文员">行政文员</a>
                        <a href="/job?q=主管">主管</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="job-list-wrapper">
        <div class="area">
            <ul class="job-list">
                @foreach($itemlist as $item)
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
            <div style="padding: 15px 0;">{{$pagination}}</div>
        </div>
    </div>
@stop
