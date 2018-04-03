@extends('layouts.member')

@section('title', '我的话题')

@section('content')
    <div class="console-title">
        <a href="{{url('mobile/forum')}}" class="button float-right">发表话题</a>
        <h2>我的话题</h2>
    </div>
    <div class="content-div">
        <form method="post" id="listForm">
            {{csrf_field()}}
            <table cellpadding="0" cellspacing="0" width="100%" border="0" class="listtable">
                <thead>
                <tr>
                    <th width="30"><input type="checkbox" class="checkbox" title="" data-action="checkall"></th>
                    <th>话题</th>
                    <th width="200">时间</th>
                    <th width="60">点击</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemlist as $item)
                    <tr>
                        <td><input type="checkbox" class="checkbox checkmark" title="" name="items[]" value="{{$item['tid']}}"></td>
                        <td><h3><a href="{{url('mobile/forum/topic/'.$item['tid'].'.html')}}" target="_blank">{{$item['title']}}</a></h3></td>
                        <td>{{@date('Y-m-d H:i:s', $item['created_at'])}}</td>
                        <td>{{$item['views']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="display: block; padding: 15px 0;">
                <div class="float-right">{!! $pagination !!}</div>
                <input type="button" class="button" value="提交" id="submit">
            </div>
        </form>
    </div>


    <script type="text/javascript">
        $(function () {
            $("#submit").on('click', function () {
                if ($(".checkmark:checked").length === 0){
                    DSXUI.error('请选择选项');
                    return false;
                }

                DSXUI.showConfirm('删除确认', '确认要删除所选信息吗?', function () {
                    $("#listForm").submit();
                });
            });
        });
    </script>
@stop
