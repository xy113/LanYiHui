@extends('layouts.mobile')

@section('title', '我的简历')

@section('content')
    <div class="resume">
        <ul class="resume-list">
            @foreach($itemlist as $item)
                <li id="resume_{{$item['id']}}">
                    <span>
                        <a href="{{url('/mobile/resume/edit?id='.$item['id'])}}">编辑</a>
                        <a rel="delete" data-id="{{$item['id']}}">删除</a>
                    </span>
                    <div class="title" data-link="{{url('/mobile/resume/detail/'.$item['id'].'.html')}}">{{$item['title']}}</div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="bottom-bar">
        <div class="fixed">
            <div class="btn" data-link="{{url('/mobile/resume/edit')}}">+新增简历</div>
        </div>
    </div>
    <script type="text/javascript">
        (function () {
            $("[rel=delete]").on('click', function () {
                if (confirm('确认要删除该简历吗?')){
                    var id = $(this).attr('data-id');
                    $.ajax({
                        url:'{{url('/mobile/resume/delete')}}',
                        data:{id:id},
                        success:function (response) {
                            if (response.errcode === 0){
                                $("#resume_"+id).remove();
                            }else {
                                DSXUI.error(response.errmsg);
                            }
                        }
                    });
                }
            });
        })();
    </script>
@stop
